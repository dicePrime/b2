<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

/**
 * Description of SuiviParcController
 *
 * @author BMHB8456
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\Modele\ListingCAModel;
use AppBundle\Commons\Tools;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Modele\B2BParcHebdoModele;
use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\Modele\SSP;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;

class SuiviParcController extends Controller {

    //put your code here

    public function indexAction() {
        return $this->render('suiviparc/suiviParc.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..')));
    }

    public function syntheseHebdoForAnneeAction() {
        $request = $this->getRequest();
        $annee = $request->get('annee');

        $connection = $this->get("database_connection");
        $b2bParcHebdoModel = new B2BParcHebdoModele($connection);

        $syntheses = $b2bParcHebdoModel->syntheseHebdo();
        $synthese = $syntheses['synthese'];

        //print_r($synthese['semaines']);

        $chartsTable = array();




        $semaines = $syntheses['semaines'][$annee];
        $tmpChart = new Highchart();
        $tmpChart->title->text("Evolution globale hebdomadaire du parc");
        $tmpChart->xAxis->title(array('text' => "Semaine"));
        $tmpChart->yAxis->title(array("text" => "Valeur"));
        $tmpChart->xAxis->categories($semaines);

        $evolutionNetAdd = array();
        $evolutionActivation = array();
        $evolutionResiliation = array();
        $evolutionParc = array();
        foreach ($semaines as $semaine) {
            //print_r($semaine);
            $evolutionNetAdd[] = $synthese[$annee][$semaine][Tools::$_TOTAL][Tools::$_NET_ADD];
            $evolutionActivation[] = $synthese[$annee][$semaine][Tools::$_TOTAL][Tools::$_ACTIVATION];
            $evolutionResiliation[] = $synthese[$annee][$semaine][Tools::$_TOTAL][Tools::$_RESILIATION];
            $evolutionParc[] = $synthese[$annee][$semaine][Tools::$_TOTAL][Tools::$_PARC];
        }
        //print_r($evolutionComparee);
        $totalChart = array(
            array("name" => "Evolution globale du parc sur " . $annee, "data" => $evolutionParc),
            array("name" => "Evolution globale des activations sur " . $annee, "data" => $evolutionActivation),
            array("name" => "Evolution globale des résiliations sur " . $annee, "data" => $evolutionResiliation),
            array("name" => "Evoluiton globale du NetAdd sur " . $annee, "data" => $evolutionNetAdd));

        $tmpChart->series($totalChart);

        $chartsTable['TOTAL' . $annee] = $tmpChart;

        $tmpChartMobile = new Highchart();
        $tmpChartMobile->chart->renderTo('MOBILE' . $annee);
        $tmpChartMobile->title->text("Evolution globale hebdomadaire du parc mobile");
        $tmpChartMobile->xAxis->title(array('text' => "Semaine"));
        $tmpChartMobile->yAxis->title(array("text" => "Valeur"));
        $tmpChartMobile->xAxis->categories($semaines);

        $evolutionNetAddMobile = array();
        $evolutionActivationMobile = array();
        $evolutionResiliationMobile = array();
        $evolutionParcMobile = array();
        foreach ($semaines as $semaine) {
            $evolutionNetAddMobile[] = $synthese[$annee][$semaine]['MOBILE'][Tools::$_NET_ADD];
            $evolutionActivationMobile[] = $synthese[$annee][$semaine]['MOBILE'][Tools::$_ACTIVATION];
            $evolutionResiliationMobile[] = $synthese[$annee][$semaine]['MOBILE'][Tools::$_RESILIATION];
            $evolutionParcMobile[] = $synthese[$annee][$semaine]['MOBILE'][Tools::$_PARC];
        }
        //print_r($evolutionComparee);
        $mobileChart = array(
            array("name" => "Evolution globale du parc sur mobile" . $annee, "data" => $evolutionParcMobile),
            array("name" => "Evolution globale des activations mobiles sur " . $annee, "data" => $evolutionActivationMobile),
            array("name" => "Evolution globale des résiliations mobiles sur " . $annee, "data" => $evolutionResiliationMobile),
            array("name" => "Evoluiton globale du NetAdd mobile sur " . $annee, "data" => $evolutionNetAddMobile));

        $tmpChartMobile->series($mobileChart);

        $chartsTable['MOBILE' . $annee] = $tmpChartMobile;

        $tmpChartInternet = new Highchart();
        $tmpChartInternet->title->text("Evolution globale hebdomadaire du parc internet");
        $tmpChartInternet->xAxis->title(array('text' => "Semaine"));
        $tmpChartInternet->yAxis->title(array("text" => "Valeur"));
        $tmpChartInternet->xAxis->categories($semaines);

        $evolutionNetAddInternet = array();
        $evolutionActivationInternet = array();
        $evolutionResiliationInternet = array();
        $evolutionParcInternet = array();
        foreach ($semaines as $semaine) {
            $evolutionNetAddInternet[] = $synthese[$annee][$semaine]['INTERNET'][Tools::$_NET_ADD];
            $evolutionActivationInternet[] = $synthese[$annee][$semaine]['INTERNET'][Tools::$_ACTIVATION];
            $evolutionResiliationInternet[] = $synthese[$annee][$semaine]['INTERNET'][Tools::$_RESILIATION];
            $evolutionParcInternet[] = $synthese[$annee][$semaine]['INTERNET'][Tools::$_PARC];
        }
        //print_r($evolutionComparee);
        $internetChart = array(
            array("name" => "Evolution globale du parc internet sur " . $annee, "data" => $evolutionParcInternet),
            array("name" => "Evolution globale des activations internet sur " . $annee, "data" => $evolutionActivationInternet),
            array("name" => "Evolution globale des résiliations internet sur " . $annee, "data" => $evolutionResiliationInternet),
            array("name" => "Evoluiton globale du NetAdd sur internet " . $annee, "data" => $evolutionNetAddInternet));

        $tmpChartInternet->series($internetChart);

        $chartsTable['INTERNET' . $annee] = $tmpChartInternet;
        $response = new JsonResponse();
        $response->setData(json_encode($chartsTable));

        return $response;
    }

    public function syntheseHebdoAction() {
        $connection = $this->get("database_connection");
        $b2bParcHebdoModel = new B2BParcHebdoModele($connection);

        $syntheses = $b2bParcHebdoModel->syntheseHebdo();


        return $this->render('suiviparc/syntheseHebdo.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                    'synthese' => $syntheses['synthese'],
                    'annees' => $syntheses['annees'],
                    'types' => $syntheses['types'],
                    'semaines' => $syntheses['semaines']));
    }

    public function activationHebdoParClientAction() {
        
        $request = $this->getRequest();
        
        if($request->isXmlHttpRequest())
        {
        
        $draw =  $request->get("draw");
        $orderByColumnIndexTable = $request->get('order');
        
        $orderByColumnIndex = $orderByColumnIndexTable[0]['column'];
        
        $columns = $request->get('columns');
        $orderBy = $columns[$orderByColumnIndex]['data'];
        $orderTypeTable = $request->get('order');
        $orderType = $orderTypeTable[0]['dir'];
        
        $start = $request->get('start');
        $length = $request->get('length');
        
        
        $connection = $this->get("database_connection");
        
        $dataManager = new DataManager("RecBTBActSynWeek", $connection);
        
        
        
        $resultat = $dataManager->findAll();
        
        
        $allElementCount = $dataManager->countAll();
        
        $data = array();
        
        foreach($resultat as $res)
        {
            $tmp = array();
            $tmp['SEM'] = $res->getSem();
            $tmp['CUSTCODE'] = $res->getCustCode();
            $tmp['INTITULE'] = $res->getIntitule();
            $tmp['DES'] = $res->getDes();
            $tmp['TYPE1'] = $res->getType1();
            $tmp['CB1'] = $res->getCB1();
            $tmp['ACT1'] = $res->getAct1();
            $tmp['SUSP1'] = $res->getSusp1();
            
            $data[] = $tmp;
        }
        
        $result = array(
                "draw" => intval($draw),
                "recordsTotal" => $allElementCount,
                "recordsFiltered" => count($resultat),
                "data" => $data);
        $response = new JsonResponse(json_encode($result));
        
        return $response;
        }
        else
        {
          return $this->render('suiviparc/synthes.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                    ));  
        }
        
    }

}
