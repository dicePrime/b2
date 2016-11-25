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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use AppBundle\Entity\ListingCA;
use AppBundle\Modele\ListingCAModel;
use AppBundle\Modele\B2BVendeurModele;
use AppBundle\Modele\B2BSyntheseCAModel;
use AppBundle\Commons\Tools;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Description of SyntheseCAController
 *
 * @author BMHB8456
 */
class SyntheseCAController extends Controller {
    //put your code here
    
    public function indexAction() {
        
        $connection = $this->get("database_connection");
        $syntheseCAModel = new B2BSyntheseCAModel($connection);
        $synthese = $syntheseCAModel->getSynthese();
        
       
        
        return $this->render('suivica/syntheseCA.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                    'synthese' => $synthese['synthese'],
                    'annees' => $synthese['annees']
        ));
    }

}
