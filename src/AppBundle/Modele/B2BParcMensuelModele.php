<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

/**
 * Description of B2BParcMensuelModele
 *
 * @author BMHB8456
 */

use AppBundle\Commons\Tools;
use AppBundle\Entity\B2BParcHebdo;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;

class B2BParcMensuelModele {

    //put your code here
    private $connection;
    private $dataManager;

    public function __construct($connection) {

        $this->connection = $connection;
        $this->dataManager = new DataManager("VueCroissanceParc", $connection);
    }
    
    public function syntheseMensuelle() {
        $resultat = array('synthese' => array(),
            'annees' => array(),
            'types' => array(),
            'mois' => array());

        $datas = $this->dataManager->findAll();



        foreach ($datas as $data) {

            $annee  = substr($data->getMois(), 0, 4);
            $mois = substr($data->getMois(), 4, 2);
            
            if (!in_array($annee, $resultat['annees'])) {
                $resultat['annees'][] = $annee;
            }

            if (!in_array($data->getType1(), $resultat['types'])) {
                $resultat['types'][] = $data->getType1();
            }
            
            
            if (isset($resultat['mois'][$annee])) {
                if (!in_array($mois, $resultat['mois'][$annee]))
                    $resultat['mois'][$annee][] = $mois;
            }
            else {
                $resultat['mois'][$annee][] = $mois;
            }
            
            $resultat['synthese'][$annee][$mois][$data->getType1()]['PARC'] = $data->getParc();

            $resultat['synthese'][$annee][$mois][$data->getType1()]['PARC_ACTIF'] = $data->getParcActif();
            
            $resultat['synthese'][$annee][$mois][$data->getType1()]['ACTIVATION'] = $data->getActivation();

            $resultat['synthese'][$annee][$mois][$data->getType1()]['RESILIATION'] = $data->getResiliation();

            $resultat['synthese'][$annee][$mois][$data->getType1()]['NETADD'] = $data->getNetAdd();

            $resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['ACTIVATION'] = isset($resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['ACTIVATION']) ?
                    $resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['ACTIVATION'] + $data->getActivation() : 0.0;

            $resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['RESILIATION'] = isset($resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['RESILIATION']) ?
                    $resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['RESILIATION'] + $data->getRESILIATION() : 0.0;

            $resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['NETADD'] = isset($resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['NETADD']) ?
                    $resultat['synthese'][$annee]['TOTAL'][$data->getType1()]['NETADD'] + $data->getNetAdd() : 0.0;
        }

        print_r($resultat['types']);

        foreach ($resultat['annees'] as $annee) {
            /// $resultat['synthese'][$data->getAnnee()][$data->getSemaine()][$data->getType1()]['PARC'] + $data->getParc(); 

            $previousMois = "00";
            foreach ($resultat['mois'][$annee] as $semaine) {
                $resultat['synthese'][$annee][$semaine]['TOTAL']['PARC'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC'] +
                        $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC'];

                $resultat['synthese'][$annee][$semaine]['TOTAL']['PARC_ACTIF'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC_ACTIF'] +
                        $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC_ACTIF'];
                
                $resultat['synthese'][$annee][$semaine]['TOTAL']['ACTIVATION'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['ACTIVATION'] +
                        $resultat['synthese'][$annee][$semaine]['MOBILE']['ACTIVATION'];

                $resultat['synthese'][$annee][$semaine]['TOTAL']['RESILIATION'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['RESILIATION'] +
                        $resultat['synthese'][$annee][$semaine]['MOBILE']['RESILIATION'];

                $resultat['synthese'][$annee][$semaine]['TOTAL']['NETADD'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['NETADD'] +
                        $resultat['synthese'][$annee][$semaine]['MOBILE']['NETADD'];


                if ($previousMois < $semaine) {
                    $resultat['synthese'][$data->getAnnee()]['TOTAL']['PARC'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC'] +
                            $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC'];
                    $resultat['synthese'][$data->getAnnee()]['TOTAL']['PARC_ACTIF'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC_ACTIF'] +
                            $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC_ACTIF'];

                    $resultat['synthese'][$data->getAnnee()]['TOTAL']['MOBILE']['PARC'] = $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC'];

                    $resultat['synthese'][$data->getAnnee()]['TOTAL']['INTERNET']['PARC'] = $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC'];
                }
                $previousSemaine = $semaine;
            }

            $resultat['synthese'][$annee]['TOTAL']['ACTIVATION'] = $resultat['synthese'][$annee]['TOTAL']['INTERNET']['ACTIVATION'] +
                    $resultat['synthese'][$annee]['TOTAL']['MOBILE']['ACTIVATION'];

            $resultat['synthese'][$annee]['TOTAL']['RESILIATION'] = $resultat['synthese'][$annee]['TOTAL']['INTERNET']['RESILIATION'] +
                    $resultat['synthese'][$annee]['TOTAL']['MOBILE']['RESILIATION'];

            $resultat['synthese'][$annee]['TOTAL']['NETADD'] = $resultat['synthese'][$annee]['TOTAL']['INTERNET']['NETADD'] +
                    $resultat['synthese'][$annee]['TOTAL']['MOBILE']['NETADD'];



            //Total des activation, résiliations, netadd par année et par type
        }

        return $resultat;
    }
    
}
    