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
use AppBundle\Modele\B2BRequeteModel;
use AppBundle\Modele\B2BOperationLigneModel;

/**
 * Description of ListingRequetesController
 *
 * @author BMHB8456
 */
class ListingRequetesController extends Controller {

    //put your code here
    
    public static $_DATE_FORMAT = "Y-m-d H:i:s";
    

    public function listingRequetesAction() {
        $connection = $this->get("database_connection");
        $b2bRequeteModel = new B2BRequeteModel($connection);
        $request = $this->getRequest();
        $session = $request->getSession();


        $debut = $request->get('dateDebut');
        $fin = $request->get('dateFin');
        
        //print_r($debut.'-'.$fin);
        //print_r($debut);
        $ticket = $request->get('numeroTicket');
        $compteParam = $request->get('compteClient');
        $operationParam = $request->get('operation');
        $etatParam = $request->get('etat');
        $nomClientParam = $request->get('nomClient');
        
        print_r($operationParam);
        
        if(NULL == $request->getSession()->get('listeOperations'))
        {
            $b2bOperationLigneModel = new B2BOperationLigneModel($connection);       
            $operations = $b2bOperationLigneModel->getAllOperationsLigne();
            $session()->set('listeOperations', $operations);
        }
        
        if(NULL == $request->getSession()->get('etats'))
        {
            $session->set('etats', array('Ouvert', 'Fermé'));
        }
        
        print_r($etatParam);
        
        if (null == $debut && null == $fin && null == $ticket && null == $compteParam &&
                null == $operationParam && null == $etatParam && null == $nomClientParam) {
            $requetes = array();
        } else {
            $requetes = $b2bRequeteModel->getB2BRequetes($debut, $fin, $ticket, $compteParam, $operationParam, $etatParam, $nomClientParam);
        }


        return $this->render('requetes/listeRequetes.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                    'requetes' => $requetes));
    }

}
