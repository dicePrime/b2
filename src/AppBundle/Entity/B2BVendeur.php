<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of B2BVendeur
 *
 * @author BMHB8456
 */
class B2BVendeur {
    //put your code here
    
    private $nVendeur;
    
    private $nAscom;
    
    private $nomVendeur;
    
    private $autreNom;
    
    private $matricule;
    
    private $telephone;
    
    private $email;
    
    private $metier;
    
    private $nEquipe;
    
    private $ville;
    
    private $region;
    
    private $photo;
    
    private $actif;
    
    private $statut;
    
    private $vendeur;
    
    function getNVendeur() {
        return $this->nVendeur;
    }

    function getNAscom() {
        return $this->nAscom;
    }

    function getNomVendeur() {
        return $this->nomVendeur;
    }

    function getAutreNom() {
        return $this->autreNom;
    }

    function getMatricule() {
        return $this->matricule;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getEmail() {
        return $this->email;
    }

    function getMetier() {
        return $this->metier;
    }

    function getNEquipe() {
        return $this->nEquipe;
    }

    function getVille() {
        return $this->ville;
    }

    function getRegion() {
        return $this->region;
    }

    function getPhoto() {
        return $this->photo;
    }

    function getActif() {
        return $this->actif;
    }

    function getStatut() {
        return $this->statut;
    }

    function getVendeur() {
        return $this->vendeur;
    }

    function setNVendeur($nVendeur) {
        $this->nVendeur = $nVendeur;
    }

    function setNAscom($nAscom) {
        $this->nAscom = $nAscom;
    }

    function setNomVendeur($nomVendeur) {
        $this->nomVendeur = $nomVendeur;
    }

    function setAutreNom($autreNom) {
        $this->autreNom = $autreNom;
    }

    function setMatricule($matricule) {
        $this->matricule = $matricule;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMetier($metier) {
        $this->metier = $metier;
    }

    function setNEquipe($nEquipe) {
        $this->nEquipe = $nEquipe;
    }

    function setVille($ville) {
        $this->ville = $ville;
    }

    function setRegion($region) {
        $this->region = $region;
    }

    function setPhoto($photo) {
        $this->photo = $photo;
    }

    function setActif($actif) {
        $this->actif = $actif;
    }

    function setStatut($statut) {
        $this->statut = $statut;
    }

    function setVendeur($vendeur) {
        $this->vendeur = $vendeur;
    }


    
    
}
