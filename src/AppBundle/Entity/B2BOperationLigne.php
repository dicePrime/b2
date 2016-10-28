<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of B2BOperationLigne
 *
 * @author BMHB8456
 */
class B2BOperationLigne {
    //put your code here
    
    private $libelle;
    
    function getLibelle() {
        return $this->libelle;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }


}
