<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

/**
 * Description of DetailsRequeteController
 *
 * @author BMHB8456
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Modele\B2BRequeteModel;
use AppBundle\Modele\B2BCommentaireRequeteModel;
use AppBundle\Entity\B2BCommentaireRequete;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Commons\Tools;

class DetailsRequeteController extends Controller {
    //put your code here
    
    public function detailsAction($nRequete)
    {
        $connection = $this->get("database_connection");
        $b2bRequeteModel = new B2BRequeteModel($connection);
        
        $requete = $b2bRequeteModel->getRequeteByNRequete($nRequete);
        
        return $this->render('requetes/detailsRequete.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                    'requete' => $requete));
    }
    
    public function clotureRequeteAction()
    {
        $request = $this->getRequest();
        
        $utilisateur =$request->getSession()->get('utilisateur');
        $detailsIssue = $request->get('detailsIssue');
        $issue = $request->get('issue');
        
        $idRequete = $request->get('idRequete');
        date_default_timezone_set("Africa/Douala");
        $dateCloture = date("Y-m-d H:i:s", time());
        
        $connection = $this->get("database_connection");
        $b2bRequeteModel = new B2BRequeteModel($connection);
        
        $requete = $b2bRequeteModel->getRequeteByNRequete($idRequete);
        
        $requete->setStatut("Fermé");
        $requete->setIssue($issue);
        $requete->setDetailsIssue($detailsIssue);
        $requete->setDateCloture($dateCloture);
        $requete->setNUserCloture($utilisateur->getIdUtilisateur());
        
        Tools::writeFile("testCloture.txt", print_r($requete, true));
        
        $code = $b2bRequeteModel->persist($requete);
        
        if($code != null)
        {
            $resultat = 'OK';
            $message =  'Requête cloturée avec succès';
        }
        else
        {
            $resultat = 'NOK';
            $message = "La requête n'a pas pu être clotruée";
        }
        $result = array("resultat" => $resultat, "message" => $message);      
        $response = new JsonResponse();
        $response->setData($result);
        return $response;
        
    }
    
    public function insertCommentaireRequeteAction()
    {
        $request = $this->getRequest();
        
        $utilisateur = $request->getSession()->get('utilisateur');
        $commentaire = $request->get('commentaire');
        $idRequete = $request->get('idRequete');
        
        date_default_timezone_set("Africa/Douala");
        $dateCreation = date("Y-m-d H:i:s", time());
        
        $b2bCommentaireRequete = new B2BCommentaireRequete();
        $b2bCommentaireRequete->setIdRequete($idRequete);
        $b2bCommentaireRequete->setNUserInit($utilisateur->getIdUtilisateur());
        $b2bCommentaireRequete->setCommentaire($commentaire);
        $b2bCommentaireRequete->setNomUtilisateur($utilisateur->getNom());
        $b2bCommentaireRequete->setDateCommentaire($dateCreation);
        
        
        
        $connection = $this->get("database_connection");
        $b2bCommentaireRequeteModel = new B2BCommentaireRequeteModel($connection);
        
        $code = $b2bCommentaireRequeteModel->persist($b2bCommentaireRequete);
        
        if($code != null)
        {
            $resultat = "OK";
            $message = "Commentaire Enregistré avec succès";
        }
        else
        {
            $resultat = "NOK";
            $message = "Le commentaire n'a pas pu être enregistré";
        }
        $result = array("resultat" => $resultat, "message" => $message);      
        $response = new JsonResponse();
        $response->setData($result);
        return $response;
        
        
    }
}
