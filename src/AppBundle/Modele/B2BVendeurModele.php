<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Commons\Tools;
use AppBundle\Entity\B2BVendeur;

/**
 * Description of B2BVendeurModele
 *
 * @author BMHB8456
 */
class B2BVendeurModele {
    //put your code here
    
    public static  $_SELECT_ALL_B2B_VENDEUR = "select * from b2b_vendeur";
    
    
    private $connection;
    
    public function __contruct($connection)
    {
        $this->connection = $connection;
    }
    
    public function fetchB2BVendeur($row)
    {
      $b2bVendeur = new B2BVendeur();
      
      $b2bVendeur->setActif($row['actif']);
      $b2bVendeur->setStatut($row['statut']);
      $b2bVendeur->setVendeur($row['vendeur']);
      $b2bVendeur->setPhoto($row['photo']);
      $b2bVendeur->setRegion($row['region']);
      $b2bVendeur->setVille($row['ville']);
      $b2bVendeur->setNEquipe($row[nequipe]);
      $b2bVendeur->setMetier($row['metier']);
      $b2bVendeur->setEmail($row['email']);
      $b2bVendeur->setTelephone($row['telephone']);
      $b2bVendeur->setMatricule($row['matricule']);
      $b2bVendeur->setAutreNom($row['autrenomm']);
      $b2bVendeur->setNomVendeur($row['nomvendeur']);
      $b2bVendeur->setNAscom($row['nascom']);
      $b2bVendeur->setNVendeur($row['nvendeur']);
      
      return $b2bVendeur;
    }
    
    public function findAll()
    {
       try
      {
      $req = $this->connection->prepare(B2BVendeurModele::$_SELECT_ALL_B2B_VENDEUR);
      
      $req->execute();     
      
      $resultat = array();
      
      while($row = $req->fetch())
      {
          $resultat[] = $this->fetchB2BVendeur($row);
      }
      
      return $resultat;
      }
      catch(\Exception $ex)
      {
        Tools::writeFile("exceptions/findAllVendeurs.txt", $ex->getMessage());
        return array();  
      }  
    }
}
