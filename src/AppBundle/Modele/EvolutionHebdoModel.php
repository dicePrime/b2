<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\EvolutionHebdo;

/**
 * Description of EvolutionHebdoModel
 *
 * @author BMHB8456
 */
class EvolutionHebdoModel {

    //put your code here

    public static $_GET_ALL_EVOLUTION_HEBDO = "select * from b2b_activation_hebdo";
    private $connection;

    public function __construct($connection) {

        $this->connection = $connection;
    }

    public function fetchEvolutionHebdo($row) {
        $evolutionHebdo = new EvolutionHebdo();

        $evolutionHebdo->setActivation($row['activation']);
        $evolutionHebdo->setAnnee($row['annee']);
        $evolutionHebdo->setSemaine($row['sem']);
        $evolutionHebdo->setType1($row['type1']);
        $evolutionHebdo->setParc($row['parc']);
        $evolutionHebdo->setResiliation($row['resiliation']);

        return $evolutionHebdo;
    }

    public function findAll() {
        try {
            $req = $this->connection->prepare(DetailsHebdoModel::$_GET_ALL_EVOLUTION_HEBDO);

            $req->execute();

            $resultat = array();

            while ($row = $req->fetch()) {
                $resultat[] = $this->fetchEvolutionHebdo($row);
            }
            return $resultat;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/findAll.txt", $ex->getMessage());
            return array();
        }
    }
    
}
    