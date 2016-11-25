<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of B2BParcHebdo
 *
 * @author BMHB8456
 */
class B2BParcHebdo {
    //put your code here
    
    private $annee;
    
    private $semaine;
    
    private $type;
    
    private $parc;
    
    private $activation;
    
    private $resiliation;
    
    private $netAdd;
    
    
    function getAnnee() {
        return $this->annee;
    }

    function getSemaine() {
        return $this->semaine;
    }

    function getType() {
        return $this->type;
    }

    function getParc() {
        return $this->parc;
    }

    function getActivation() {
        return $this->activation;
    }

    function getResiliation() {
        return $this->resiliation;
    }

    function getNetAdd() {
        return $this->netAdd;
    }

    function setAnnee($annee) {
        $this->annee = $annee;
    }

    function setSemaine($semaine) {
        $this->semaine = $semaine;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setParc($parc) {
        $this->parc = $parc;
    }

    function setActivation($activation) {
        $this->activation = $activation;
    }

    function setResiliation($resiliation) {
        $this->resiliation = $resiliation;
    }

    function setNetAdd($netAdd) {
        $this->netAdd = $netAdd;
    }

        
    public function setData($array)
    {
      //print_r($array);
       
      if(isset($array['activation'])) $this->setActivation($array['activation']);
      if(isset($array['annee'])) $this->setAnnee($array['annee']);
      if(isset($array['sem'])) $this->setSemaine($array['sem']);
      if(isset($array['netadd']))$this->setNetAdd($array['netadd']);
      if(isset($array['resiliation'] )) $this->setResiliation($array['resiliation']);
      if(isset($array['parc'] ))$this->setParc($array['parc']);
      if(isset($array['type1'] )) $this->setType($array['type1']);
      
    }
}
