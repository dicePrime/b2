<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace diceprime\Bundle\ORMBundle\Classes;

/**
 * Description of DBConfig
 *
 * @author BMHB8456
 */
class DBConfig {

    //put your code here

    public static $db = array(
        'B2BDesRequete' => array(
            'class' => '\AppBundle\Entity\B2BDesRequete',
            'table' => 'b2b_des_requete',
            'fields' => array('id', 'nom', 'email'),
            'pk' => 'id'
        ),
        'B2BLigneDesRequete' => array('class' => '\AppBundle\Entity\B2BLigneDesRequete',
            'table' => 'b2b_ligne_des_requete',
            'fields' => array('id' => 'id', 'id_requete' => 'idRequete', 'id_des' => 'idDes'),
            'pk' => 'id'
        ),
        'B2BRequete' => array(
            'class' => '\AppBundle\Entity\B2BRequete',
            'table' => 'b2b_requete',
            'fields' => array(
                'NRequete', 'NClient', 'NAscom', 'NumeroTicket',
                'Date_reception', 'Date_transmission', 'Date_Cloture',
                'Destinataire_dsc', 'Responsable_dsc', 'Date_traitement_dsc', 'Ligne',
                'PlageNumero', 'Operation', 'Justificatif', 'Remarques_Initiales',
                'Remarques_traitement', 'NUSerInit', 'NuserCloture', 'Statut', 'PJ1', 'Source',
                'Nom_Client', 'Compte_Client'),
            'fields_mapping'=>array(
                'NRequete' => 'nRequete', 'NClient' => 'nClient', 'NAscom' => 'nAscom',
                'NumeroTicket' => 'numeroTicket', 'Date_reception' => 'dateReception',
                'Date_transmission' => 'dateTransmission', 'Date_Cloture' => 'dateCloture',
                'Destinataire_dsc' => 'destinataireDSC', 'Responsable_dsc' => 'responsableDSC',
                'Date_traitement_dsc' => 'dateTraitementDSC', 'Ligne' => 'ligne', 'PlageNumero'=> 'plageNumero',
                'Operation' => 'operation', 'Justificatif' => 'justificatif', 'Remarques_Initiales'=> 'remarquesInitiales',
                'Remarques_traitement'=> 'remarquesTraitement', 'NUserInit'=> 'nUserInit',
                'NuserCloture' => 'nUserCloture', 'Statut' => 'statut', 'PJ1'=>'pJ1', 
                'Source' => 'source',
                'Nom_Client' => 'nomClient', 'Compte_Client' => 'compteClient'
            ),
            'pk' => 'NRequete'
        )
    );

}  