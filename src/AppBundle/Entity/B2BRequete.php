<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Entity;
/**
 * Description of B2BRequete
 *
 * @author BMHB8456
 */
class B2BRequete {
    //put your code here
    
    //numero de la requete
    private $nRequete;
    
    //Le numéro du client
    private $nClient;
    
    //Le numéro de l'ascom
    private $nAscom;
    
    //Le numero du ticket
    private $numeroTicket;
    
    //la date de reception
    private $dateReception;
    
    //La date de 
    private $dateTransmission;
    
    //Le telephone du gestionnaire
    private $telephoneGestionnaire;    
    
    private $ligneConcernee;
    
    private $dateCloture;
    
    private $destinataireDSC;
    
    private $dateCreation;
    
    private $nomClient;
    
    private $compteClient;
    
    private $source;
    
    private $operation;
    
    private $statut;
    
    private $initiateur;
    
    function getInitiateur() {
        return $this->initiateur;
    }

    function setInitiateur($initiateur) {
        $this->initiateur = $initiateur;
    }

        
    
    function getNRequete() {
        return $this->nRequete;
    }

    function getNClient() {
        return $this->nClient;
    }

    function getNAscom() {
        return $this->nAscom;
    }

    function getNumeroTicket() {
        return $this->numeroTicket;
    }

    function getDateReception() {
        return $this->dateReception;
    }

    function getDateTransmission() {
        return $this->dateTransmission;
    }

    function getTelephoneGestionnaire() {
        return $this->telephoneGestionnaire;
    }

    function getLigneConcernee() {
        return $this->ligneConcernee;
    }

    function getDateCloture() {
        return $this->dateCloture;
    }

    function getDestinataireDSC() {
        return $this->destinataireDSC;
    }

    function setNRequete($nRequete) {
        $this->nRequete = $nRequete;
    }

    function setNClient($nClient) {
        $this->nClient = $nClient;
    }

    function setNAscom($nAscom) {
        $this->nAscom = $nAscom;
    }

    function setNumeroTicket($numeroTicket) {
        $this->numeroTicket = $numeroTicket;
    }

    function setDateReception($dateReception) {
        $this->dateReception = $dateReception;
    }

    function setDateTransmission($dateTransmission) {
        $this->dateTransmission = $dateTransmission;
    }

    function setTelephoneGestionnaire($telephoneGestionnaire) {
        $this->telephoneGestionnaire = $telephoneGestionnaire;
    }

    function setLigneConcernee($ligneConcernee) {
        $this->ligneConcernee = $ligneConcernee;
    }

    function setDateCloture($dateCloture) {
        $this->dateCloture = $dateCloture;
    }

    function setDestinataireDSC($destinataireDSC) {
        $this->destinataireDSC = $destinataireDSC;
    }   
    function getDateCreation() {
        return $this->dateCreation;
    }

    function getNomClient() {
        return $this->nomClient;
    }

    function getCompteClient() {
        return $this->compteClient;
    }

    function getSource() {
        return $this->source;
    }

    function getOperation() {
        return $this->operation;
    }

    function getStatut() {
        return $this->statut;
    }

    function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }

    function setNomClient($nomClient) {
        $this->nomClient = $nomClient;
    }

    function setCompteClient($compteClient) {
        $this->compteClient = $compteClient;
    }

    function setSource($source) {
        $this->source = $source;
    }

    function setOperation($operation) {
        $this->operation = $operation;
    }

    function setStatut($statut) {
        $this->statut = $statut;
    }   
       
    
}
