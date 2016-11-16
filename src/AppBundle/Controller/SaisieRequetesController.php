<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Modele\B2BVendeurModele;
use AppBundle\Modele\B2BOperationLigneModel;
use AppBundle\Modele\B2BDesRequeteModel;
use AppBundle\Entity\B2BRequete;
use AppBundle\Entity\B2BLigneDesRequete;
use AppBundle\Modele\B2BLigneDesRequeteModel;
use AppBundle\Modele\B2BRequeteModel;
use AppBundle\Commons\Tools;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of SaisieRequetesController
 *
 * @author BMHB8456
 */
class SaisieRequetesController extends Controller {

    //put your code here



    public function saisieRequeteAction(Request $request) {

        $connection = $this->get("database_connection");

        $b2bVendeurModel = new B2BVendeurModele($connection);

        $b2bDesRequeteModel = new B2BDesRequeteModel($connection);

        $session = $request->getSession();


        //On enregistre les informations du formulaire
        if ($request->isXmlHttpRequest()) {



            return $this->render('requetes/saisieRequetes.html.twig', array(
                        'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..')));
        } else { //on affiche le formulaire
            if (NULL == $session->get('vendeurs')) {
                $vendeurs = $b2bVendeurModel->findAll();
                $session->set('vendeurs', $vendeurs);
            } else {
                $vendeurs = $session->get('vendeurs');
            }

            if (NULL == $session->get('destinataires')) {
                $destinataires = $b2bDesRequeteModel->findAll();
                $session->set('destinataires', $destinataires);
            } else {
                $destinataires = $session->get('destinataires');
            }

            if (NULL == $request->getSession()->get('listeOperations')) {
                $b2bOperationLigneModel = new B2BOperationLigneModel($connection);
                $operations = $b2bOperationLigneModel->getAllOperationsLigne();
                $session->set('listeOperations', $operations);
            } else {
                $operations = $session->get('listeOperations');
            }
            return $this->render('requetes/saisieRequetes.html.twig', array(
                        'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..')));
        }
    }

    private function populateLignesDestinataires($request, B2BLigneDesRequeteModel $b2bLigneDesRequeteModel, $idRequete) {

        $destinataires = $request->get('destinataires');

        $lignesAInserer = array();

        Tools::writeFile("testDestinataires.txt", $destinataires);

        foreach ($destinataires as $destinataire) {

            $nouveauDestinataire = new B2BLigneDesRequete();

            $nouveauDestinataire->setIdDes($destinataire['id']);
            $nouveauDestinataire->setIdRequete($idRequete);
            $nouveauDestinataire->setNature($destinataire['nature']);

            $lignesAInserer[] = $nouveauDestinataire;
        }

        return $lignesAInserer;
    }

    private function moveUploadedFiles($session, $idRequete) {
        $ds = "/";

        $filesToUpload = $session->get('filesToUpload');

        $imagesPath = "uploads" . $ds . "requetes" . $ds . $idRequete . $ds;

        $uploadedFiles = array();

        Tools::writeFile("testImagesPath.txt", $imagesPath);
        if (!file_exists($imagesPath)) {
            mkdir($imagesPath);
        }
        
        Tools::writeFile("test1FilesToUpload.txt", $filesToUpload);

        foreach ($filesToUpload as $file) {
            $uploadedFiles[] = $imagesPath . basename($file);
            Tools::writeFile("testFileMoved.txt", $imagesPath.basename($file));
            rename($file, $imagesPath.basename($file));
        }
        
        return $uploadedFiles;
    }
    
    

    /**
     * 
     */
    public function insertRequeteAction() {
        try {
            $request = $this->getRequest();
            $connection = $this->get("database_connection");
            $b2bRequestModel = new B2BRequeteModel($connection);
            $b2bLigneDesRequeteModel = new B2BLigneDesRequeteModel($connection);
            $b2bDesRequetesModel = new B2BDesRequeteModel($connection);

            $newB2BRequete = $this->populateRequete($request);

            $lastInsertedId = $b2bRequestModel->persist($newB2BRequete);

            if ($lastInsertedId) {
                //On récupère les destinataires 
                $lignesDestinataires = $this->populateLignesDestinataires($request, $b2bLigneDesRequeteModel, $lastInsertedId);

                //On enregistre les destinataires (id, id_req, nature)
                $b2bLigneDesRequeteModel->persistMany($lignesDestinataires);

                //On déplace les fichiers uploadés vers leur destination finale et on en profite pour les 
                //récupérer pour les joindre au mail.
                $uploadedFiles = $this->moveUploadedFiles($request->getSession(), $lastInsertedId);

                $ccEmails = array();
                $emails = array();
                foreach ($lignesDestinataires as $ligneDestinataire) {
                    $destinataire = $b2bDesRequetesModel->find(intval($ligneDestinataire->getIdDes()));
                    if ($ligneDestinataire->getNature() == 'To') {
                        $emails[] = $destinataire->getEmail();
                    } else if ($ligneDestinataire->getNature() == 'Cc') {
                        $ccEmails[] = $destinataire->getEmail();
                    }
                }

                $newB2BRequete->setNRequete($lastInsertedId);

               $ccEmails[]= 'joel.ndzie@orange.com';

                $this->nouvelleRequeteEmail($newB2BRequete, $ccEmails, $emails, $uploadedFiles);
                $session->set("filesToUpload", null);
                $result = array("result" => "OK", "message" => "Requête enregistrée avec succès");
                $response = new JsonResponse();
                $response->setData($result);
                return $response;
            }
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/insertRequeteAction.txt", $ex->getMessage());
            $result = array("result" => "NOK", "message" => "Une erreur s'est produite lors de la création de la requête");
            $response = new JsonResponse();
            $response->setData($result);
            return $response;
        }
    }

    private function nouvelleRequeteEmail($requete, $ccEmails, $emails, $filesLocation) {
        try {
            $messenger = \Swift_Message::newInstance();
            
            $emails[] = "joelpatrickndzie@gmail.com";
            $messenger->setFrom("npatrickjoel@gmail.com", "BEETOO");

            $messenger->setTo($emails);

            $messenger->setCc($ccEmails);



            $messenger->setBody($this->renderView('emails/nouvelleRequete.html.twig', array('base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                        'requete' => $requete)), 'text/html');

            foreach ($filesLocation as $fileLocation) {
                if (file_exists($fileLocation)) {
                    $attach = \Swift_Attachment::fromPath($fileLocation);
                    $messenger->attach($attach);
                }
            }

            $this->get('mailer')->send($messenger);
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/nouvelleRequeteEmail.txt", $ex->getMessage() . "\r" . $ex->getTraceAsString());
        }
    }

    private function extractFileNameFromFileAbsoluteName($absoluteName) {
        $ds = "/";
        $sep = $ds;
        $tab = preg_split($sep, $absoluteName);
        $tabLength = count($tab);
        if ($tab[$tabLength - 1] != null) {
            return $tab[$tabLength - 1];
        } else {
            return false;
        }
    }

    public function populateRequete($request) {
        $newB2BRequete = new B2BRequete();

        $newB2BRequete->setSource($request->get('source'));
        $newB2BRequete->setOperation($request->get('operation'));
        $newB2BRequete->setCompteClient($request->get('compteClient'));
        $newB2BRequete->setNClient($newB2BRequete->getCompteClient());
        
        //A modifier.
        $newB2BRequete->setNUserInit(1);
        $newB2BRequete->setNomClient($request->get('nomClient'));
        $newB2BRequete->setLigne($request->get('ligne'));
        $newB2BRequete->setRemarquesInitiales($request->get('remarques'));
        $newB2BRequete->setDateReception($request->get('dateReception'));
        date_default_timezone_set("Africa/Douala");
        $newB2BRequete->setDateCreation(date("Y-m-d H:i:s", time()));
        $newB2BRequete->setStatut("Ouvert");

        $session = $request->getSession();

        $ds = "/";

        $uploadedFiles = $session->get('filesToUpload');
        Tools::writeFile("testUploadedFiless.txt", $uploadedFiles);
        $filesList = "";

        foreach ($uploadedFiles as $file) {

            if (strlen($filesList) > 0) {
                $filesList = $filesList . ";" . basename($file);
            }
            else
            {
                $filesList = basename($file);
            }
        }
        Tools::writeFile("testFilesList.txt", $filesList);
        $newB2BRequete->setFichiersJointsCreation($filesList);

        return $newB2BRequete;
    }

}
