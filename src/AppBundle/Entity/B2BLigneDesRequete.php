<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of B2BLigneDesRequete
 *
 * @author BMHB8456
 */
class B2BLigneDesRequete {
    //put your code here
    
    private $id;
    
    private $idRequete;
    
    private $idDes;
    
    function getId() {
        return $this->id;
    }

    function getIdRequete() {
        return $this->idRequete;
    }

    function getIdDes() {
        return $this->idDes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdRequete($idRequete) {
        $this->idRequete = $idRequete;
    }

    function setIdDes($idDes) {
        $this->idDes = $idDes;
    }
    
}
