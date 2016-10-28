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
use AppBundle\Modele\DetailsHebdoModel;
use AppBundle\Entity\DetailsHebdo;



/**
 * Description of ActivationHebdoParClientController
 *
 * @author BMHB8456
 */
class DetailsHebdoController extends Controller {
    //put your code here
    
  
    public function detailsHebdoAction(Request $request)
    {
       $connection = $this->get("database_connection");
       
       $detailsHebdoModel = new DetailsHebdoModel($connection);
       
       $detaisHebdo = $detailsHebdoModel->findAll();
       
       
       return $this->render('suiviparc/detailsHebdo.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'detailsHebdo' => $detaisHebdo));
    }
    
}
