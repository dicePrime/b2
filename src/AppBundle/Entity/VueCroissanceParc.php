<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of VueCroissanceParc
 *
 * @author BMHB8456
 */
class VueCroissanceParc {

    //put your code here


    private $mois;
    private $type1;
    private $parc;
    private $suspension;
    private $activation;
    private $resiliation;
    private $netAdd;
    private $parcActif;

    public function setData($array) {

        $this->setMois($array['MOIS']);
        $this->setType1($array['TYPE1']);
        $this->setParc($array['PARC']);
        $this->setSuspension($array['SUSPENSION']);
        $this->setActivation($array['ACTIVATION']);
        $this->setResiliation($array['RESILIATION']);
        $this->setNetAdd($array['NETADD']);
        $this->setParcActif($array['PARC_ACTIF']);
    }

    function getMois() {
        return $this->mois;
    }

    function getType1() {
        return $this->type1;
    }

    function getParc() {
        return $this->parc;
    }

    function getSuspension() {
        return $this->suspension;
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

    function getParcActif() {
        return $this->parcActif;
    }

    function setMois($mois) {
        $this->mois = $mois;
    }

    function setType1($type1) {
        $this->type1 = $type1;
    }

    function setParc($parc) {
        $this->parc = $parc;
    }

    function setSuspension($suspension) {
        $this->suspension = $suspension;
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

    function setParcActif($parcActif) {
        $this->parcActif = $parcActif;
    }

}
