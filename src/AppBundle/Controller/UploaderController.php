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
use AppBundle\Commons\Tools;

/**
 * Description of Uploader
 *
 * @author BMHB8456
 */
class UploaderController extends Controller {

    //put your code here

    public function uploadAction() {
        
        $ds = "/";  // On récupère le séparateur du système de fichier
        $request = $this->getRequest(); // On récupère la requête associée
        $session = $request->getSession(); // On récupère la session
        
        /**
         * La variable de session filesToUpload contient la liste de tous 
         * les fichiers qui doivent être uploadés.
         * elle est vidées aussitôt que ces fichiers ont été déplacés
         * vers leur repertoire définitif
         */
        if(NULL == $session->get('filesToUpload'))
        {
            $filesToUpload = array();
        }
        
        else
        {
            $filesToUpload = $session->get('filesToUpload');
        }
        
        
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
            
            $filesToUpload[] = $targetFile;
        }
        $session->set('filesToUpload', $filesToUpload);
        return new \Symfony\Component\HttpFoundation\JsonResponse();
    }
    /**
     * Cette fonction AJAX
     * permet de supprimer un fichier de la liste des fichiers à
     * uploader
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteFileAction()
    {
        $ds = "/";  //1
        $request = $this->getRequest();
        $session = $request->getSession();
        
        
        
        $fileName = $request->get('filename');
        
        if(NULL == $session->get('filesToUpload'))
        {
            $filesToUpload = array();
        }
        
        else
        {
            $filesToUpload = $session->get('filesToUpload');
        }
        
        Tools::writeFile("beforeDeleta.txt", $filesToUpload);
        
        $sessionFolder = 'uploads'.$ds.'tmp'.$ds.session_id();
        $targetPath = $sessionFolder.$ds.$fileName;
        Tools::writeFile('testTarget.txt', $targetPath);
        if(file_exists($targetPath))
        {
            
            unlink($targetPath);
     
            $i = 0;
            foreach($filesToUpload as $file)
            {
                if($file == $targetPath)
                {
                    Tools::writeFile('occurence.txt', $file);
                   $filesToUpload[$i] = NULL; 
                }
                $i++;
            }
        }
        
        $session->set('filesToUpload', $filesToUpload);
        Tools::writeFile("afterDelete.txt", $filesToUpload);
        return new \Symfony\Component\HttpFoundation\JsonResponse();
    }

}
