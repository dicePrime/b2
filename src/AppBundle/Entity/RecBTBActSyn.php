<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of RecBTBActSyn
 *
 * @author BMHB8456
 */
class RecBTBActSyn {
    //put your code here
    
    private $nEnreg;
    
    private $mois;
    
    private $custCode;
    
    private $intitule;
    
    private $des;
    
    private $type1;
    
    private $csCurbalance;
    
    private $prevBalance;
    
    private $lbcDate;
    
    private $cb1;
    
    private $susp1;
    
    private $act1;
    
    private $deac1;
    
    
    public function setData($array)
    {
        $this->setNEnreg($array['NENREG']);
        $this->setMois($array['MOIS']);
        $this->setCustCode($array['CUSTCODE']);
        $this->setIntitule($array['INTITULE']);
        $this->setDes($array['DES']);
        $this->setType1($array['TYPE1']);
        $this->setCsCurbalance($array['CSCURBALANCE']);
        $this->setPrevBalance($array['PREV_BALANCE']);
        $this->setLbcDate($array['LBC_DATE']);
        $this->setCB1($array['CB1']);
        $this->setSusp1($array['SUSP1']);
        $this->setAct1($array['ACT1']);
        $this->setDEAC1($array['DEAC1']);
    }
    
    function getNEnreg() {
        return $this->nEnreg;
    }

    function getMois() {
        return $this->mois;
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

    function getCsCurbalance() {
        return $this->csCurbalance;
    }

    function getPrevBalance() {
        return $this->prevBalance;
    }

    function getLbcDate() {
        return $this->lbcDate;
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

    function setNEnreg($nEnreg) {
        $this->nEnreg = $nEnreg;
    }

    function setMois($mois) {
        $this->mois = $mois;
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

    function setCsCurbalance($csCurbalance) {
        $this->csCurbalance = $csCurbalance;
    }

    function setPrevBalance($prevBalance) {
        $this->prevBalance = $prevBalance;
    }

    function setLbcDate($lbcDate) {
        $this->lbcDate = $lbcDate;
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
    
}
