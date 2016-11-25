<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of RecBTBActSynWeek
 *
 * @author BMHB8456
 */
class RecBTBActSynWeek {
    //put your code here
    
    private $sem;
    
    
    private $custCode;
    
    private $intitule;
    
    private $des;
    
    private $type1;
    
    private $cscurbalance;
    
    private $prevBalance;
    
    private $lbcDate;
    
    private $cb1;
    
    private $susp1;
    
    private $act1;
    
    private $deac1;
    
    private $annee;
    
    private $grandCompte;
    
    
    
    function getSem() {
        return $this->sem;
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

    function getCscurbalance() {
        return $this->cscurbalance;
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

    function getAnnee() {
        return $this->annee;
    }

    function getGrandCompte() {
        return $this->grandCompte;
    }

    function setSem($sem) {
        $this->sem = $sem;
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

    function setCscurbalance($cscurbalance) {
        $this->cscurbalance = $cscurbalance;
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

    function setAnnee($annee) {
        $this->annee = $annee;
    }

    function setGrandCompte($grandCompte) {
        $this->grandCompte = $grandCompte;
    }

    public function setData($array)
    {
       $this->setSem($array['SEM']);
       $this->setCustCode($array['CUSTCODE']);
       $this->setIntitule($array['INTITULE']);
       $this->setDes($array['DES']);
       $this->setType1($array['TYPE1']);
       $this->setCscurbalance($array['CSCURBALANCE']);
       $this->setPrevBalance($array['PREV_BALANCE']);
       $this->setLbcDate($array['LBC_DATE']);
       $this->setCb1($array['CB1']);
       $this->setSusp1($array['SUSP1']);
       $this->setAct1($array['ACT1']);
       $this->setDeac1($array['DEAC1']);
       $this->setAnnee($array['ANNEE']);
       $this->setGrandCompte($array['GRANDCOMPTE']);
    }
    
    
}
