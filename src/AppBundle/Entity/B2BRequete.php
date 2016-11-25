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
    // private $telephoneGestionnaire;   
    
    private $dateCreation;

    private $dateCloture;
    private $destinataireDSC;
    private $responsableDSC;
    private $dateTraitementDSC;
    private $ligne;
    private $plageNumero;
    //private $dateCreation;

    private $nomClient;
    private $justificatif;
    private $remarquesInitiales;
    private $remarquesTraitement;
    private $nUserInit;
    private $nUserCloture;
    private $compteClient;
    private $source;
    private $operation;
    private $statut;
    private $pJ1; // la chaine des fichiers joints
    private $fichiersJointsCreation;
    private $tableauFichiersJointsCreation;
    private $fichiersJointsTraitement;
    private $tableauFichiersJointsTraitement;
    private $commentairesRequete;
    private $issue;
    private $detailsIssue;

    public function setData($data) {
        try
        {
        //print_r("dans setData");
        $this->setDateCloture($data['Date_Cloture']);
        $this->setDateReception($data['Date_reception']);
        $this->setDateTransmission($data['Date_transmission']);
        $this->setDestinataireDSC($data['Destinataire_dsc']);
        //$this->setResponsableDSC($data['Responsable_dsc']);
        $this->setLigne($data['Ligne']);
        $this->setNAscom($data['NAscom']);
        $this->setNumeroTicket($data['NumeroTicket']);
        $this->setNRequete($data['NRequete']);
        //$this->setDateCreation($data['date_creation']);
        //$this->setOperation($data['operation']);
        $this->setNomClient($data['Nom_Client']);
        $this->setCompteClient($data['Compte_Client']);
        $this->setStatut($data['Statut']);
        $this->setOperation($data['Operation']);
        $this->setRemarquesInitiales($data['Remarques_Initiales']);
        $this->setRemarquesTraitement($data['Remarques_traitement']);
        $this->setFichiersJointsCreation($data['fichiers_joints_creation']);
        $this->setFichiersJointsTraitement($data['fichiers_joints_traitement']);
        $this->setNUserInit($data['NUserInit']);
        $this->setNUserCloture($data['NuserCloture']);
        $this->setDateCreation($data['date_creation']);
        //$this->setInitiateur($data['NomPrenom']);
        $this->setpJ1($data['PJ1']);
        $this->setIssue($data['issue']);
        $this->setDetailsIssue($data['details_issue']);
        $this->setDateCloture($data['Date_Cloture']);
        
        $fichiersJointsArray = preg_split("#;#", $this->getFichiersJointsCreation());
        $this->setTableauFichiersJointsCreation($fichiersJointsArray);
        
       
        //print_r($this);
        }
        catch(\Exception $ex)
        {
            print_r($ex->getMessage());
            
        }
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

    function getDateCloture() {
        return $this->dateCloture;
    }

    function getDestinataireDSC() {
        return $this->destinataireDSC;
    }

    function getResponsableDSC() {
        return $this->responsableDSC;
    }

    function getDateTraitementDSC() {
        return $this->dateTraitementDSC;
    }

    function getLigne() {
        return $this->ligne;
    }

    function getPlageNumero() {
        return $this->plageNumero;
    }

    function getNomClient() {
        return $this->nomClient;
    }

    function getJustificatif() {
        return $this->justificatif;
    }

    function getRemarquesInitiales() {
        return $this->remarquesInitiales;
    }

    function getRemarquesTraitement() {
        return $this->remarquesTraitement;
    }

    function getNUserInit() {
        return $this->nUserInit;
    }

    function getNUserCloture() {
        return $this->nUserCloture;
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

    function getPJ1() {
        return $this->pJ1;
    }

    function getFichiersJointsArray() {
        return $this->fichiersJointsArray;
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

    function setDateCloture($dateCloture) {
        $this->dateCloture = $dateCloture;
    }

    function setDestinataireDSC($destinataireDSC) {
        $this->destinataireDSC = $destinataireDSC;
    }

    function setResponsableDSC($responsableDSC) {
        $this->responsableDSC = $responsableDSC;
    }

    function setDateTraitementDSC($dateTraitementDSC) {
        $this->dateTraitementDSC = $dateTraitementDSC;
    }

    function setLigne($ligne) {
        $this->ligne = $ligne;
    }

    function setPlageNumero($plageNumero) {
        $this->plageNumero = $plageNumero;
    }

    function setNomClient($nomClient) {
        $this->nomClient = $nomClient;
    }

    function setJustificatif($justificatif) {
        $this->justificatif = $justificatif;
    }

    function setRemarquesInitiales($remarquesInitiales) {
        $this->remarquesInitiales = $remarquesInitiales;
    }

    function setRemarquesTraitement($remarquesTraitement) {
        $this->remarquesTraitement = $remarquesTraitement;
    }

    function setNUserInit($nUserInit) {
        $this->nUserInit = $nUserInit;
    }

    function setNUserCloture($nUserCloture) {
        $this->nUserCloture = $nUserCloture;
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

    function setPJ1($pJ1) {
        $this->pJ1 = $pJ1;
    }

    function setFichiersJointsArray($fichiersJointsArray) {
        $this->fichiersJointsArray = $fichiersJointsArray;
    }

    function getFichiersJointsCreation() {
        return $this->fichiersJointsCreation;
    }

    function getTableauFichiersJointsCreation() {
        return $this->tableauFichiersJointsCreation;
    }

    function getFichiersJointsTraitement() {
        return $this->fichiersJointsTraitement;
    }

    function getTableauFichiersJointsTraitement() {
        return $this->tableauFichiersJointsTraitement;
    }

    function setFichiersJointsCreation($fichiersJointsCreation) {
        $this->fichiersJointsCreation = $fichiersJointsCreation;
    }

    function setTableauFichiersJointsCreation($tableauFichiersJointsCreation) {
        $this->tableauFichiersJointsCreation = $tableauFichiersJointsCreation;
    }

    function setFichiersJointsTraitement($fichiersJointsTraitement) {
        $this->fichiersJointsTraitement = $fichiersJointsTraitement;
    }

    function setTableauFichiersJointsTraitement($tableauFichiersJointsTraitement) {
        $this->tableauFichiersJointsTraitement = $tableauFichiersJointsTraitement;
    }
    
    function getDateCreation() {
        return $this->dateCreation;
    }

    function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }
    function getCommentairesRequete() {
        return $this->commentairesRequete;
    }

    function setCommentairesRequete($commentairesRequete) {
        $this->commentairesRequete = $commentairesRequete;
    }
    
    function getIssue() {
        return $this->issue;
    }

    function getDetailsIssue() {
        return $this->detailsIssue;
    }

    function setIssue($issue) {
        $this->issue = $issue;
    }

    function setDetailsIssue($detailsIssue) {
        $this->detailsIssue = $detailsIssue;
    }


}
