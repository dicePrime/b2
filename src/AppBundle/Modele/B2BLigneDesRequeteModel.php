<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\B2BLigneDesRequete;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;

/**
 * Description of B2BLigneDesRequeteModel
 *
 * @author BMHB8456
 */
class B2BLigneDesRequeteModel {

    //put your code here

    private $connection;
    private $dataManager;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->dataManager = new DataManager("B2BLigneDesRequete", $connection);
    }

    public function findAll() {
        return $this->dataManager->findAll();
    }
    
    public function persist(B2BLigneDesRequete $b2bLigneDesRequete)
    {
       $this->dataManager->persist($b2bLigneDesRequete); 
    }
    
    public function persistMany($b2bLignesDesRequete)
    {
        foreach($b2bLignesDesRequete as $b2bLigneDesRequete)
        {
            $this->persist($b2bLigneDesRequete);
        }
    }

}
