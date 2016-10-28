<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\B2BOperationLigne;

/**
 * Description of B2BOperationLigneModel
 *
 * @author BMHB8456
 */
class B2BOperationLigneModel {
    //put your code here
    
    public static $_QUERY = "select * from b2b_operation_ligne";
    
    private $connexion;
    
    public function __construct($connexion) {
        
        $this->connexion = $connexion;
    }
    
    public function fetchOperation($row)
    {
       $b2bOperationLigne = new B2BOperationLigne();
       $b2bOperationLigne->setLibelle($row['Libellle_Operation']);
       
       return $b2bOperationLigne;
    }
    
    public function getAllOperationsLigne()
    {
        try
        {
        $req = $this->connexion->prepare(B2BOperationLigneModel::$_QUERY);
        
        $resultat = array();
        
        $req->execute();
        
        while($row = $req->fetch())
        {
            $resultat[] = $this->fetchOperation($row);
        }
        print_r($resultat);
        return $resultat;
        }
        catch(\Exception $ex)
        {
            Tools::writeFile('getAllOperationsLigneException.txt', $ex->getMessage());
            return array();
        }
    }
}
