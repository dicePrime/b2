<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace b2\AppBundle\Entity;

/**
 * Description of B2BActivationHebdo
 *
 * @author BMHB8456
 */
class B2BActivation {
    //put your code here
    
   /**
    * L'année au format AAAA
    * @var integer
    */
    private $annee;
    
    /**
     * La semaine au format SS exemple 01, 05, 12 etc ...
     * @var string
     */
    private $semaine;
    
    /**
     * Le code du client au format ss
     * @var string
     */
    private $custcode;
    
    /**
     * Le nom du client
     * @var string 
     */
    private $intitule;    
    
    /**
     *
     * Le nom de lignes total pour la semaine semaine
     * @var int 
     */
    private $parcSemaine;
    
    private $parcClientSemaine;
    
    private $parcClientMois;
    
    private $activationSemaine;
    
    private $activationClientSemaine;
    
    private $activationClientMois;
    
    private $resiliationMois;
    
    private $resiliationClientSemaine;
    
    private $resiliationClientMois;
    
    private $netAddSemaine;
    
    private $netAddClientSemaine;
    
    private $netAddClientMois;
    
    
    
    
    function getAnnee() {
        return $this->annee;
    }

    function getSemaine() {
        return $this->semaine;
    }

    function getCustcode() {
        return $this->custcode;
    }

    function getIntitule() {
        return $this->intitule;
    }

    function getParcSemaine() {
        return $this->parcSemaine;
    }

    function getParcClientSemaine() {
        return $this->parcClientSemaine;
    }

    function getParcClientMois() {
        return $this->parcClientMois;
    }

    function getActivationSemaine() {
        return $this->activationSemaine;
    }

    function getActivationClientSemaine() {
        return $this->activationClientSemaine;
    }

    function getActivationClientMois() {
        return $this->activationClientMois;
    }

    function getResiliationMois() {
        return $this->resiliationMois;
    }

    function getResiliationClientSemaine() {
        return $this->resiliationClientSemaine;
    }

    function getResiliationClientMois() {
        return $this->resiliationClientMois;
    }

    function getNetAddSemaine() {
        return $this->netAddSemaine;
    }

    function getNetAddClientSemaine() {
        return $this->netAddClientSemaine;
    }

    function getNetAddClientMois() {
        return $this->netAddClientMois;
    }

    function setAnnee($annee) {
        $this->annee = $annee;
    }

    function setSemaine($semaine) {
        $this->semaine = $semaine;
    }

    function setCustcode($custcode) {
        $this->custcode = $custcode;
    }

    function setIntitule($intitule) {
        $this->intitule = $intitule;
    }

    function setParcSemaine($parcSemaine) {
        $this->parcSemaine = $parcSemaine;
    }

    function setParcClientSemaine($parcClientSemaine) {
        $this->parcClientSemaine = $parcClientSemaine;
    }

    function setParcClientMois($parcClientMois) {
        $this->parcClientMois = $parcClientMois;
    }

    function setActivationSemaine($activationSemaine) {
        $this->activationSemaine = $activationSemaine;
    }

    function setActivationClientSemaine($activationClientSemaine) {
        $this->activationClientSemaine = $activationClientSemaine;
    }

    function setActivationClientMois($activationClientMois) {
        $this->activationClientMois = $activationClientMois;
    }

    function setResiliationMois($resiliationMois) {
        $this->resiliationMois = $resiliationMois;
    }

    function setResiliationClientSemaine($resiliationClientSemaine) {
        $this->resiliationClientSemaine = $resiliationClientSemaine;
    }

    function setResiliationClientMois($resiliationClientMois) {
        $this->resiliationClientMois = $resiliationClientMois;
    }

    function setNetAddSemaine($netAddSemaine) {
        $this->netAddSemaine = $netAddSemaine;
    }

    function setNetAddClientSemaine($netAddClientSemaine) {
        $this->netAddClientSemaine = $netAddClientSemaine;
    }

    function setNetAddClientMois($netAddClientMois) {
        $this->netAddClientMois = $netAddClientMois;
    }

    
    
}
