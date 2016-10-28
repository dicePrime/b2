<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of EvolutionHebdo
 *
 * @author BMHB8456
 */
class EvolutionHebdo {
    //put your code here
    
    private $annee;
    private $semaine;
    private $type1;
    private $activation;
    private $resiliation;
    private $parc;
    
    function getAnnee() {
        return $this->annee;
    }

    function getSemaine() {
        return $this->semaine;
    }

    function getType1() {
        return $this->type1;
    }

    function getActivation() {
        return $this->activation;
    }

    function getResiliation() {
        return $this->resiliation;
    }

    function setAnnee($annee) {
        $this->annee = $annee;
    }

    function setSemaine($semaine) {
        $this->semaine = $semaine;
    }

    function setType1($type1) {
        $this->type1 = $type1;
    }

    function setActivation($activation) {
        $this->activation = $activation;
    }

    function setResiliation($resiliation) {
        $this->resiliation = $resiliation;
    }
    
    function getParc() {
        return $this->parc;
    }

    function setParc($parc) {
        $this->parc = $parc;
    }


}
