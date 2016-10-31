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
 * Description of Uploader
 *
 * @author BMHB8456
 */
class UploaderController extends Controller {

    //put your code here

    public function uploadAction() {
        $ds = DIRECTORY_SEPARATOR;  //1
        
        $sessionFolder = 'uploads'.$ds.'tmp'.$ds.session_id();
        if(!file_exists($sessionFolder))
        {
            mkdir($sessionFolder);
        }
        $storeFolder = $sessionFolder;   //2

        if (!empty($_FILES)) {

            $tempFile = $_FILES['file']['tmp_name'];          //3             

            $targetPath = $storeFolder . $ds;  //4

            $targetFile = $targetPath . $_FILES['file']['name'];  //5

            move_uploaded_file($tempFile, $targetFile); //6
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse();
    }

}
