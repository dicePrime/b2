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
    
    public static  $_SELECT_ALL_B2B_VENDEUR = "select * from b2b_vendeur order by NomVendeur asc";
    
    
    private $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function fetchB2BVendeur($row)
    {
      $b2bVendeur = new B2BVendeur();
      
      $b2bVendeur->setActif($row['Actif']);
      $b2bVendeur->setStatut($row['Statut']);
      $b2bVendeur->setVendeur($row['Vendeur']);
      $b2bVendeur->setPhoto($row['Photo']);
      $b2bVendeur->setRegion($row['Region']);
      $b2bVendeur->setVille($row['Ville']);
      $b2bVendeur->setNEquipe($row['NEquipe']);
      $b2bVendeur->setMetier($row['Metier']);
      $b2bVendeur->setEmail($row['Email']);
      $b2bVendeur->setTelephone($row['Telephone']);
      $b2bVendeur->setMatricule($row['Matricule']);
      $b2bVendeur->setAutreNom($row['AutreNom']);
      $b2bVendeur->setNomVendeur($row['NomVendeur']);
      $b2bVendeur->setNAscom($row['NAscom']);
      $b2bVendeur->setNVendeur($row['NVendeur']);
      
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
