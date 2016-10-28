<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Modele\DefaultModel;
use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\Modele\UtilisateurDAO;
use AppBundle\Entity\Utilisateur;


/**
 * Description of SaisieRequetesController
 *
 * @author BMHB8456
 */
class SaisieRequetesController {
    //put your code here
    
    public function saisieRequetesAction(Request $request)
    {
       $connection = $this->get("database_connection");
       
       $detailsHebdoModel = new DetailsHebdoModel($connection);
       
       $detaisHebdo = $detailsHebdoModel->findAll();
       
       
       return $this->render('requetes/saisieRequetes.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..')));
    }
}
