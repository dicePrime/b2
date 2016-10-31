<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace b2\AppBundle\Entity;

/**
 * Description of B2BDestinataireRequete
 *
 * @author BMHB8456
 */
class B2BDestinataireRequete {
    //put your code here
    
    private $id;
    
    private $nom;
    
    private $email;
    
    private $nature;
    
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getEmail() {
        return $this->email;
    }

    function getNature() {
        return $this->nature;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setNature($nature) {
        $this->nature = $nature;
    }


}
