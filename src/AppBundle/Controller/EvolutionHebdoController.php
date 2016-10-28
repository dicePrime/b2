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

use AppBundle\Entity\EvolutionHebdo;
use AppBundle\Modele\EvolutionHebdoModel;
/**
 * Description of EvolutionHebdoController
 *
 * @author BMHB8456
 */
class EvolutionHebdoController {

//put your code here

 
    public function evolutionHebdoAction(Request $request) {
        $connection = $this->get("database_connection");

        $detailsHebdoModel = new DetailsHebdoModel($connection);

        $detaisHebdo = $detailsHebdoModel->findAll();
        
        //Evolution activations
        //Evolution resiliations
        //Evolutions NetAdd

        return $this->render('suiviparc/evolutionHebdo.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                    ));
    }

}
