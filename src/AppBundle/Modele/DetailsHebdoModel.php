<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;


use AppBundle\Entity\DetailsHebdo;
use AppBundle\Commons\Tools;

/**
 * Description of ActivationHebdoParClient
 *
 * @author BMHB8456
 */
class DetailsHebdoModel {
    //put your code here
    
    public static $_GET_ALL_ACTIVATION_HEBDO_PAR_CLIENT = "select * from vw_parc_hebdo_par_commercial";
    
    
    private $connection;  
    
    public function __construct($connection) {
        
        $this->connection = $connection;
    }
    
    public function fetchActivationHebdoParClient($row)
    {
        
        $resultat = new DetailsHebdo();        
        try
        {
        $resultat->setAnnee($row['annee']);
        $resultat->setSemaine($row['sem']);
        $resultat->setCustCode($row['custcode']);
        $resultat->setIntitule($row['intitule']);
        $resultat->setDes($row['des']);
        $resultat->setType1($row['type1']);
        $resultat->setCb1($row['cb1']);
        $resultat->setSusp1($row['susp1']);
        $resultat->setAct1($row['act1']);
        $resultat->setDeac1($row['deact1']);
        $resultat->setSegment($row['segment']);
        $resultat->setVille($row['ville']);
        $resultat->setRegion($row['region']);
        $resultat->setNomVendeur($row['nomvendeur']);
        
        return $resultat;      
        }
        catch(\Exception $ex)
        {        
            Tools::writeFile("exceptions/fetchActivationHebdoParClient.txt", $ex->getMessage());
            return $resultat;
        }      
        
    }
    
    public function findAll()            
    {
      try
      {
      $req = $this->connection->prepare(DetailsHebdoModel::$_GET_ALL_ACTIVATION_HEBDO_PAR_CLIENT);
      
      $req->execute();     
      
      $resultat = array();
      
      while($row = $req->fetch())
      {
          $resultat[] = $this->fetchActivationHebdoParClient($row);
      }
      
      return $resultat;
      }
      catch(\Exception $ex)
      {
        Tools::writeFile("exceptions/findAll.txt", $ex->getMessage());
        return array();  
      }
    }  
    
    
      }
