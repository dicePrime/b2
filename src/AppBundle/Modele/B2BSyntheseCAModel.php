<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

/**
 * Description of B2BSyntheseCAModel
 *
 * @author BMHB8456
 */
use AppBundle\Commons\Tools;
use AppBundle\Entity\B2BSyntheseCA;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;

class B2BSyntheseCAModel {

    //put your code here

    private $connection;
    private $dataManager;

    public function __construct($connection) {

        $this->connection = $connection;
        $this->dataManager = new DataManager("B2BSyntheseCA", $connection);
    }

    public function findAll() {
        return $this->dataManager->findAll();
    }

    public function getSynthese() {
        $resultat = array('annees' => array(), 'synthese' => array());
        //{{ synthese[annee][mois][region]['LL'] }}
        $elements = $this->findAll();

        foreach ($elements as $element) {

            $resultat['synthese'][$element->getAnnee()][$element->getMois()][$element->getRegion()][$element->getTypeCompte()] = $element->getCA();
            $resultat['synthese'][$element->getAnnee()][$element->getMois()]['GLOBAL'][$element->getTypeCompte()] = isset($resultat['synthese'][$element->getAnnee()][$element->getMois()]['GLOBAL'][$element->getTypeCompte()]) ? $resultat['synthese'][$element->getAnnee()][$element->getMois()]['GLOBAL'][$element->getTypeCompte()] + $element->getCA() : 0.0;
            $resultat['synthese'][$element->getAnnee()][$element->getMois()]['GLOBAL']['GLOBAL'] = isset($resultat['synthese'][$element->getAnnee()][$element->getMois()]['GLOBAL']['GLOBAL']) ? $resultat['synthese'][$element->getAnnee()][$element->getMois()]['GLOBAL']['GLOBAL'] + $element->getCA() : 0.0;
            
            $resultat['synthese'][$element->getAnnee()][$element->getRegion()][$element->getTypeCompte()] = isset($resultat['synthese'][$element->getAnnee()][$element->getRegion()][$element->getTypeCompte()]) ? $resultat['synthese'][$element->getAnnee()][$element->getRegion()][$element->getTypeCompte()] + $element->getCA() : 0.0;
            
            $resultat['synthese'][$element->getAnnee()]['GLOBAL'][$element->getTypeCompte()] = isset($resultat['synthese'][$element->getAnnee()]['GLOBAL'][$element->getTypeCompte()]) ? $resultat['synthese'][$element->getAnnee()]['GLOBAL'][$element->getTypeCompte()] + $element->getCA() : 0.0;
            $resultat['synthese'][$element->getAnnee()]['GLOBAL']['GLOBAL'] = isset($resultat['synthese'][$element->getAnnee()]['GLOBAL']['GLOBAL']) ? $resultat['synthese'][$element->getAnnee()]['GLOBAL']['GLOBAL'] + $element->getCA() : 0.0;
            $resultat['synthese']['GLOBAL'][$element->getRegion()][$element->getTypeCompte()] = isset($resultat['synthese']['GLOBAL'][$element->getRegion()][$element->getTypeCompte()]) ? $resultat['synthese']['GLOBAL'][$element->getRegion()][$element->getTypeCompte()] + $element->getCA() : 0.0;
            $resultat['synthese']['GLOBAL']['GLOBAL'][$element->getTypeCompte()] = isset($resultat['synthese']['GLOBAL']['GLOBAL'][$element->getTypeCompte()]) ? $resultat['synthese']['GLOBAL']['GLOBAL'][$element->getTypeCompte()] + $element->getCA() : 0.0;
            $resultat['synthese']['GLOBAL']['GLOBAL']['GLOBAL'] = isset($resultat['synthese']['GLOBAL']['GLOBAL']['GLOBAL']) ? $resultat['synthese']['GLOBAL']['GLOBAL']['GLOBAL'] + $element->getCA() : 0.0;
            

            if (!in_array($element->getAnnee(), $resultat['annees'])) {
                $resultat['annees'][] = $element->getAnnee();
            }
        }

        return $resultat;
    }

    public function findByAnnee($annee, $mois) {
        
    }

    public function findByAnneeAndRegion($annee) {
        
    }

    public function findByAnneeMoisAndRegion($annee, $mois, $region) {
        
    }

}
