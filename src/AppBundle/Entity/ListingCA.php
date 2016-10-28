<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of ListingCA
 *
 * @author BMHB8456
 */
class ListingCA {
    //put your code here
    
    private $periode;
    
    private $client;
    
    private $compte;
    
    private $ca;
    
    private $commercial;
    
    private $region;
    
    private $grandCompte;
    
    function getPeriode() {
        return $this->periode;
    }

    function getClient() {
        return $this->client;
    }

    function getCompte() {
        return $this->compte;
    }

    function getCa() {
        return $this->ca;
    }
         
    function getGrandCompte() {
        return $this->grandCompte;
    }

    function setPeriode($periode) {
        $this->periode = $periode;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setCompte($compte) {
        $this->compte = $compte;
    }

    function setCa($ca) {
        $this->ca = $ca;
    }

    function setCommercial($commercial) {
        $this->commercial = $commercial;
    }   

    function setRegion($region) {
        $this->region = $region;
    }

    function setGrandCompte($grandCompte) {
        $this->grandCompte = $grandCompte;
    }
    
    function getCommercial() {
        return $this->commercial;
    }

    function getRegion() {
        return $this->region;
    }


    
    
}
