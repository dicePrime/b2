<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of ParcHebdoParCommercial
 *
 * @author BMHB8456
 */
class ParcHebdoParCommercial {
    //put your code here
    
    private $annee;
    
    private $semaine;
    
    private $custCode;
    
    private $intitule;
    
    private $des;
    
    private $type1;
    
    private $cb1;
    
    private $susp1;
    
    private $act1;
    
    private $deac1;
    
    private $segment;
    
    private $ville;
    
    private $region;
    
    private $nomVendeur;
    
  
    function getAnnee() {
        return $this->annee;
    }

    function getSemaine() {
        return $this->semaine;
    }

    function getCustCode() {
        return $this->custCode;
    }

    function getIntitule() {
        return $this->intitule;
    }

    function getDes() {
        return $this->des;
    }

    function getType1() {
        return $this->type1;
    }

    function getCb1() {
        return $this->cb1;
    }

    function getSusp1() {
        return $this->susp1;
    }

    function getAct1() {
        return $this->act1;
    }

    function getDeac1() {
        return $this->deac1;
    }

    function getSegment() {
        return $this->segment;
    }

    function getVille() {
        return $this->ville;
    }

    function getRegion() {
        return $this->region;
    }

    function getNomVendeur() {
        return $this->nomVendeur;
    }

    function setAnnee($annee) {
        $this->annee = $annee;
    }

    function setSemaine($semaine) {
        $this->semaine = $semaine;
    }

    function setCustCode($custCode) {
        $this->custCode = $custCode;
    }

    function setIntitule($intitule) {
        $this->intitule = $intitule;
    }

    function setDes($des) {
        $this->des = $des;
    }

    function setType1($type1) {
        $this->type1 = $type1;
    }

    function setCb1($cb1) {
        $this->cb1 = $cb1;
    }

    function setSusp1($susp1) {
        $this->susp1 = $susp1;
    }

    function setAct1($act1) {
        $this->act1 = $act1;
    }

    function setDeac1($deac1) {
        $this->deac1 = $deac1;
    }

    function setSegment($segment) {
        $this->segment = $segment;
    }

    function setVille($ville) {
        $this->ville = $ville;
    }

    function setRegion($region) {
        $this->region = $region;
    }

    function setNomVendeur($nomVendeur) {
        $this->nomVendeur = $nomVendeur;
    }


}
