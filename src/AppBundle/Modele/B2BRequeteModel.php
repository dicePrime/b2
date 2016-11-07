<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Commons\Tools;
use AppBundle\Entity\B2BRequete;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;

/**
 * Description of RequeteModel
 *
 * @author BMHB8456
 */
class B2BRequeteModel {

    //put your code here

    public static $_MIN_DATE = "2014-01-01 00:00:00";
    public static $_MAX_DATE = "2045-01-01 00:00:00";
    public static $_GET_REQUETES = "select * from b2b_requete, rec_personnel WHERE nuserInit = npersonnel AND (date_reception IS NOT NULL) AND  (date_reception >= :minDate AND date_reception <= :maxDate) AND ((numeroticket = :numeroTicket AND numeroticket <> :nullTicket ) OR (numeroticket <> :nullTicket)) AND ((compte_client <> :nullCompte AND compte_client = :compteClient) OR (compte_client <> :nullCompte)) AND ((nom_client <> :nullNomClient AND nom_client <> :nomClient) OR (nom_client <> :nullNomClient)) AND ((operation <> :nullOperation  AND operation = :operation)) AND ( (Statut = :statut) )";
    public static $_GET_REQUETES_BY_DATES = "select * from b2b_requete, rec_personnel WHERE nuserInit = npersonnel AND (date_reception IS NOT NULL) AND (date_reception >= :minDate AND date_reception <= :maxDate)";
    //public static $_GET_BY_DATES = ""

    //public static $_INSERT_INTO_B2B_REQUETE=
    
    
    private $connection;
    private $dataManager;

    public function __construct($connection) {

        $this->connection = $connection;
        $this->dataManager = new DataManager("B2BRequete", $connection);
    }
    
    /**
     * Cette requête prend en paramètre une requete et la met à jour 
     * @param B2BRequete $b2bRequete
     */
    public function updateB2BRequete(B2BRequete $b2bRequete)
    {
        
    }
    
    
    public function insertRequete(B2BRequete $requete)
    {
           
    }

    
    public function getRequetesByTicket($requetes, $ticket) {
        $resultat = array();

        foreach ($requetes as $requete) {
            if ($requete->getNumeroTicket() == $ticket) {
                $resultat[] = $requete;
            }
        }
        
        return $resultat;
    }

    public function getRequetesByCompte($requetes, $compte) {
        $resultat = array();

        foreach ($requetes as $requete) {
            if ($requete->getCompteClient() == $compte) {
                $resultat[] = $requete;
            }
        }

        return $resultat;
    }

    public function getRequtesForOperation($requetes, $operation) {
        $resultat = array();

        foreach ($requetes as $requete) {
            if ($requete->getOperation() == $operation) {
                $resultat[] = $requete;
            }
        }

        return $resultat;
    }

    public function getRequetesForEtat($requetes, $etat) {
        $resultat = array();
        
        foreach ($requetes as $requete) {
            if ($requete->getStatut() == $etat) {
                $resultat[] = $requete;
            }
        }

        return $resultat;
    }

    public function getRequetesByNomClient($requetes, $nomClient) {
        $resultat = array();

        foreach ($requetes as $requete) {
            if(Tools::like_match($nomClient, $requete->getNomClient()))
            {
                $resultat[] = $requete;
            }
            
        }

        return $resultat;
    }

    public function getB2BRequetes($debut, $fin, $ticket, $compteParam, $operationParam, $etatParam, $nomClientParam) {
        $dateDebut = NULL != $debut ? $debut : B2BRequeteModel::$_MIN_DATE;
        $dateFin = NULL != $fin ? $fin : B2BRequeteModel::$_MAX_DATE;
        try {
            $resultat = $this->dataManager->findBy(array(array('champ'=>'Date_reception','condition'=> array('condition' => '>=', 'valeur' =>$dateDebut)),
                                         array('champ'=>'Date_reception','condition' => array('condition' => '<=', 'valeur'=> $dateFin))));
                       
            if ($ticket != null and (  strlen($ticket) > 1 )) {
                $resultat = $this->getRequetesByTicket($resultat, $ticket);
            }

            if ($compteParam != null) {
                $resultat = $this->getRequetesByCompte($resultat, $compteParam);
            }

            if ($operationParam != null) {
                $resultat = $this->getRequtesForOperation($resultat, $operationParam);
            }

            if ($etatParam != null) {
                $resultat = $this->getRequetesForEtat($resultat, $etatParam);
            }

            if ($nomClientParam != null) {
                $resultat = $this->getRequetesByNomClient($resultat, $nomClientParam);
            }
            
            return $resultat;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/b2bRequeteModelException.txt", $ex->getMessage());
            return array();
        }
    }

}
