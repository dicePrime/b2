<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of Utilisateur
 *
 * @author ndziePatrick
 */
class Utilisateur {
    //put your code here
    
     
    protected $idUtilisateur;
    protected $nom;
    
    /**
     * en base de données login
     * @var type 
     */
    protected $cuid;
    
    
    protected $email;
    protected $telephone;
    protected $direction;
    protected $service;
    
    /**
     * Ce champ détermine si l'utilisateur est 
     * actif ou pas 
     * -Y = actif
     * -
     * @var type 
     */
    protected $active;
    
    /**
     * Le code d'activation (n'est pas utilisé)
     * @var type 
     */
    protected $activationCode;
    
    /**
     * Détermine si l'utilisateur est administrateur ou
     * non
     * - Y = oui
     * @var type 
     */
    protected $priv_admin;
    /**
     * Les différents rôles sont les suivants:
     * 
     * ADMIN: les administrateurs du système
     * RSP : Responsable sécurité Physique, C'est le rôle le plus élévé ils ont tous les droit que les admin sauf que les opérations des admin ne sont pas notifiées
     * SL : Ce sont les representants du responsable sécurité dans les régions.
     * @var string
     */
    protected $role = "DEFAULT";
    protected $matricule;
    protected $chaineRegions;    
    protected $regions;
    
    protected $receiveEmails = '0';
    //l_dap region
    protected $region;
    
    protected $departement;
    
    protected $profilUser;
    
    
    
    function getIdUtilisateur() {
        return $this->idUtilisateur;
    }

    function getNom() {
        return $this->nom;
    }

    function getCuid() {
        return $this->cuid;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getDirection() {
        return $this->direction;
    }

    function getService() {
        return $this->service;
    }

    function getRole() {
        return $this->role;
    }

    function getMatricule() {
        return $this->matricule;
    }

    function setIdUtilisateur($idUtilisateur) {
        $this->idUtilisateur = $idUtilisateur;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setCuid($cuid) {
        $this->cuid = $cuid;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setDirection($direction) {
        $this->direction = $direction;
    }

    function setService($service) {
        $this->service = $service;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setMatricule($matricule) {
        $this->matricule = $matricule;
    }

    function getChaineRegions() {
        return $this->chaineRegions;
    }

    function getRegions() {
        return $this->regions;
    }

    function setChaineRegions($chaineRegions) {
        $this->chaineRegions = $chaineRegions;
    }

    function setRegions($regions) {
        $this->regions = $regions;
    }
    
    function getRegion() {
        return $this->region;
    }

    function getDepartement() {
        return $this->departement;
    }

    function getProfilUser() {
        return $this->profilUser;
    }

    function setRegion($region) {
        $this->region = $region;
    }

    function setDepartement($departement) {
        $this->departement = $departement;
    }

    function setProfilUser($profilUser) {
        $this->profilUser = $profilUser;
    }
    
    function getReceiveEmails() {
        return $this->receiveEmails;
    }

    function setReceiveEmails($receiveEmails) {
        $this->receiveEmails = $receiveEmails;
    }

}
