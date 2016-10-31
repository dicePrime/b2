<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Modele\DefaultModel;
use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\Modele\UtilisateurDAO;
use AppBundle\Entity\Utilisateur;
use AppBundle\Modele\B2BVendeurModele;
use AppBundle\Modele\B2BOperationLigneModel;

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

}
