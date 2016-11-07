<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\B2BDesRequete;
use AppBundle\Commons\Tools;    
/**
 * Description of B2BDesRequeteModel
 *
 * @author BMHB8456
 */
class B2BDesRequeteModel {
    //put your code here
    
    public static  $_SELECT_ALL_FROM_B2B_DES_REQUETE = "select * from b2b_des_requete order by nom asc";
    
    
    private $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function fetchB2BDesRequete($row)
    {
      $b2bDes = new B2BDesRequete;
      
      $b2bDes->setEmail($row['email']);
      $b2bDes->setNom($row['nom']);
      $b2bDes->setId($row['id']);
            
      return $b2bDes;
    }
    
    public function findAll()
    {
       try
      {
      $req = $this->connection->prepare(B2BDesRequeteModel::$_SELECT_ALL_FROM_B2B_DES_REQUETE);
      
      $req->execute();     
      
      $resultat = array();
      
      while($row = $req->fetch())
      {
          $resultat[] = $this->fetchB2BDesRequete($row);
      }
      
      return $resultat;
      }
      catch(\Exception $ex)
      {
        Tools::writeFile("exceptions/findAllB2BDesRequete.txt", $ex->getMessage());
        return array();  
      }  
    }
}
