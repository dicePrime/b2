<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of SyntheseCA
 *
 * @author BMHB8456
 */
class B2BSyntheseCA {
    //put your code here
    
    private $annee;
    
    private $mois;
    
    private $region;
    
    private $typeCompte;
    
    private $ca;
    
    
    function getAnnee() {
        return $this->annee;
    }

    function getMois() {
        return $this->mois;
    }

    function getRegion() {
        return $this->region;
    }

    function getTypeCompte() {
        return $this->typeCompte;
    }

    function getCa() {
        return $this->ca;
    }

    function setAnnee($annee) {
        $this->annee = $annee;
    }

    function setMois($mois) {
        $this->mois = $mois;
    }

    function setRegion($region) {
        $this->region = $region;
    }

    function setTypeCompte($typeCompte) {
        $this->typeCompte = $typeCompte;
    }

    function setCa($ca) {
        $this->ca = $ca;
    }

        
    public function setData($array)
    {
      $this->setAnnee($array['annee']);
      $this->setMois($array['mois1']);
      $this->setRegion($array['region']);
      $this->setTypeCompte($array['type_compte']);
      $this->setCa($array['CA1']);
    }
}
