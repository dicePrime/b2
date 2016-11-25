<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

/**
 * Description of SuiviCAController
 *
 * @author BMHB8456
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use AppBundle\Modele\ListingCAModel;
use AppBundle\Commons\Tools;
use Symfony\Component\HttpFoundation\JsonResponse;

class SuiviCAController extends Controller {

    
    
    public function listingCAAction() {
        return $this->render('suivica/listingCA.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                    'periodes' => Tools::$_PERIODE
        ));
    }

    
    public function generateExcel($listingCA, $periodeDebut, $periodeFin)
    {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        
        $phpExcelObject->getProperties()->setCreator("Beetoo");
        $phpExcelObject->getProperties()->setTitle("Listing CA de la période de ".$periodeDebut . " à ". $periodeFin);        
         
       $activeSheetIndex = 0;
       $phpExcelObject->setActiveSheetIndex(0);
       $activeSheet = $phpExcelObject->getActiveSheet($activeSheetIndex);
       $activeSheet->setCellValue('A2', 'Période');
       $activeSheet->setCellValue('B2', 'Client');
       $activeSheet->setCellValue('C2', 'Compte');
       $activeSheet->setCellValue('D2', 'CA');
       $activeSheet->setCellValue('E2', 'Commercial');
       
       $ligne = 3;
       
       foreach($listingCA as $listing)
       {      
                    
         if( ($ligne % Tools::$_MAX_EXCEL_SHEET_ROWS) == 0)
         {   $ligne = 3;          
             $activeSheetIndex = $activeSheetIndex+1;
             $phpExcelObject->createSheet($activeSheetIndex);
             $phpExcelObject->setActiveSheetIndex($activeSheetIndex);
             $activeSheet = $phpExcelObject->getActiveSheet($activeSheetIndex);
             $phpExcelObject->getActiveSheet()->setTitle('Feuille'.$activeSheetIndex);
             $activeSheet->setCellValue('A2', 'Période');
             $activeSheet->setCellValue('B2', 'Client');
             $activeSheet->setCellValue('C2', 'Compte');
             $activeSheet->setCellValue('D2', 'CA');
             $activeSheet->setCellValue('E2', 'Commercial');
             
             $activeSheet->setCellValue('A'.$ligne, $listing->getPeriode());
             $activeSheet->setCellValue('B'.$ligne, $listing->getClient());
             $activeSheet->setCellValue('C'.$ligne, $listing->getCompte());
             $activeSheet->setCellValue('D'.$ligne, $listing->getCa());
             $activeSheet->setCellValue('E'.$ligne, $listing->getCommercial());  
         }
         
         else
         {
             $activeSheet->setCellValue('A'.$ligne, $listing->getPeriode());
             $activeSheet->setCellValue('B'.$ligne, $listing->getClient());
             $activeSheet->setCellValue('C'.$ligne, $listing->getCompte());
             $activeSheet->setCellValue('D'.$ligne, $listing->getCa());
             $activeSheet->setCellValue('E'.$ligne, $listing->getCommercial());  
         }
             $ligne = $ligne +1;
       }
       
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'listing-ca_'.$periodeDebut.'_'.$periodeFin.'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }
            
    
    public function createExcelAction($debut, $fin) 
    {
        $connection = $this->get("database_connection");
        $listingCAModel = new ListingCAModel($connection);
        $request = $this->getRequest();

        try {

            //On récupère la période de début
            $periodeDebut = $debut;

            //On récupère la période de fin
            $periodeFin = $fin;

            //On récupère l'index à partir du quel il faut faire le select
            /*$begin = $request->get('jtStartIndex');
            $end = $request->get('jtPageSize');
            $sortValue = $request->get('jtSorting');*/


            if ($periodeDebut == "-" && $periodeFin != "-") {
                $date = new \DateTime();

                $annee = date("Y");

                $mois = $date->format("m");

                if (intval($mois) < 10) {
                    $mois = "0" . $mois;
                }

                $periodeFin = $annee . $mois;
                $periodeDebut = null;
            } else if ($periodeDebut != "-" && $periodeFin == "-") {
                $date = new \DateTime();

                $annee = date("Y");

                $mois = $date->format("m");

                if (intval($mois) < 10) {
                    $mois = "0" . $mois;
                }

                $periodeDebut = $annee . $mois;
                $periodeFin = null;
            } else if ($periodeDebut == "-" && $periodeFin == "-") {

                $periodeFin = null;
                $periodeDebut = null;
            }



            //Le nombre total d'éléments entre la période de début et la période de fin
            //en affichant qu'à partir de begin et end.
            //$listingsCA = $listingCAModel->findByDebutAndFinAndLimitedAndSorted($periodeDebut, $periodeFin, intval($begin), intval($end), $sortValue);
            $listingsCA = $listingCAModel->findByDebutAndFin($periodeDebut, $periodeFin);

            $resultat = array();

            return $this->generateExcel($listingsCA, $periodeDebut, $periodeFin);

        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/listCAAction.txt", $ex->getMessage()."\n\n". $ex->getTraceAsString());
            $resultat = array("Result" => "NOK", "Records" => array());
            return null;
        }
    }

    public function listCAAction() {

        $connection = $this->get("database_connection");
        $listingCAModel = new ListingCAModel($connection);
        $request = $this->getRequest();

        try {

            //On récupère la période de début
            $periodeDebut = $request->get('debut');

            //On récupère la période de fin
            $periodeFin = $request->get('fin');

            //On récupère l'index à partir du quel il faut faire le select
            $begin = $request->get('jtStartIndex');
            $end = $request->get('jtPageSize');
            $sortValue = $request->get('jtSorting');


            if ($periodeDebut == "-" && $periodeFin != "-") {
                $date = new \DateTime();

                $annee = date("Y");

                $mois = $date->format("m");

                if (intval($mois) < 10) {
                    $mois = "0" . $mois;
                }

                $periodeFin = $annee . $mois;
                $periodeDebut = null;
            } else if ($periodeDebut != "-" && $periodeFin == "-") {
                $date = new \DateTime();

                $annee = date("Y");

                $mois = $date->format("m");

                if (intval($mois) < 10) {
                    $mois = "0" . $mois;
                }

                $periodeDebut = $annee . $mois;
                $periodeFin = null;
            } else if ($periodeDebut == "-" && $periodeFin == "-") {

                $periodeFin = null;
                $periodeDebut = null;
            }



            //Le nombre total d'éléments entre la période de début et la période de fin
            //en affichant qu'à partir de begin et end.
            $listingsCA = $listingCAModel->findByDebutAndFinAndLimitedAndSorted($periodeDebut, $periodeFin, intval($begin), intval($end), $sortValue);

            //Le nombre total d'éléments entre la période de début et la pérode de fin
            $allListingCA = $listingCAModel->findByDebutAndFin($periodeDebut, $periodeFin);


            $resultat = array();

            //On construit le tableau du résultat
            foreach ($listingsCA as $listingCA) {
                $resultat[] = array('client' => $listingCA->getClient(),
                    'periode' => $listingCA->getPeriode(),
                    'compte' => $listingCA->getCompte(),
                    'ca' => $listingCA->getCa(),
                    'commercial' => $listingCA->getCommercial());
            }
            $totalRecordCount = count($allListingCA);
            $result = array("Result" => "OK", "Records" => $resultat, "TotalRecordCount" => $totalRecordCount);
            $response = new JsonResponse();
            $response->setData($result);
            return $response;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/listCAAction.txt", $ex->getMessage());
            $resultat = array("Result" => "NOK", "Records" => array());
        }
    }

}
