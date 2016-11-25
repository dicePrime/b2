<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\B2BCommentaireRequete;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;

/**
 * Description of B2BCommentaireRequeteModel
 *
 * @author BMHB8456
 */
class B2BCommentaireRequeteModel {
    //put your code here
    
    private $connection;
    private $dataManager;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->dataManager = new DataManager("B2BCommentaireRequete", $connection);
    }
     
    public function findAll()
    {
      return $this->dataManager->findAll();
    }  
        
    public function findBy($fields)
    {
        return $this->dataManager->findBy($fields);
    }
   
    
    public function find($id)
    {
        return $this->dataManager->find($id);
    }
    
    public function persist(B2BCommentaireRequete $b2bCommentaireRequete)
    {
        return $this->dataManager->persist($b2bCommentaireRequete);
    }
 
}
