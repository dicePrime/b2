<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Modele\DefaultModel;
use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\Modele\UtilisateurDAO;
use AppBundle\Entity\Utilisateur;
use AppBundle\Modele\B2BRequeteModel;
use AppBundle\Modele\B2BOperationLigneModel;

namespace AppBundle\Controller;

/**
 * Description of nouvelleRequeteController
 *
 * @author BMHB8456
 */
class nouvelleRequeteController extends Controller{
    //put your code here
    
    public function nouvelleRequeteAction()
    {
        $connection = $this->get("database_connection");
        $b2bRequeteModel = new B2BRequeteModel($connection);
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if()
    }
}
