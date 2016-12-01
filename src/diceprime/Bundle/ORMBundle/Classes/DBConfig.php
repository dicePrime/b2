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
           
        'VueCroissanceParc' => array(
          'class' => '\AppBundle\Entity\VueCroissanceParc',
          'table' => 'vw_croissance_parc',
          'fields' => array('MOIS', 'TYPE1', 'PARC', 
              'SUSPENSION', 'ACTIVATION', 'RESILIATION', 'NETADD', 'PARC_ACTIF'),
          'fields_mapping' => array('MOIS' => 'mois', 'TYPE1' => 'type1',
              'PARC' => 'parc', 'SUSPENSION' => 'suspension', 'ACTIVATION' => 'activation',
              'RESILIATION' => 'resiliation', 'NETADD' => 'netAdd', 'PARC_ACTIF' => 'parcActif')
        ),
        
          'RecBTBActSyn' => array(
          'class' => '\AppBundle\Entity\RecBTBActSynWeek',
          'table' => 'b2b_parc_hebdo',
          'fields' => array('NENREG', 'MOIS', 'CUSTCODE', 'INTITULE',
              'DES', 'TYPE1', 'CSCURBALANCE', 'PREV_BALANCE', 'LBC_DATE',
              'CB1', 'SUSP1', 'ACT1', 'DEAC1'),
          'fields_mapping'=> array(
              'NENREG' => 'nEnreg', 'MOIS' => 'mois', 'CUSTCODE' => 'custCode',
              'INTITULE' => 'intitule', 'DES' => 'des', 'TYPE1' => 'type1',
              'CSCURBALANCE' => 'csCurbalance', 'PREV_BALANCE' => 'prevBalance',
              'LBC_DATE' => 'lbcDate', 'CB1' => 'cb1', 'SUSP1' => 'susp1',
              'ACT1' => 'act1', 'DEAC1' => 'deac1'
          )
        ),
        
        'B2BParcHebdo' => array(
            
            'class' => '\AppBundle\Entity\B2BParcHebdo',
            'table' => 'b2b_parc_hebdo',
            'fields' => array('annee', 'sem', 'type1', 'parc', 'activation', 'resiliation', 'netadd'),
            'fields_mapping' => array('annee' => 'annee', 'sem' => 'semaine',
                'type1' => 'type', 'parc'=> 'parc', 'activation' => 'activation',
                'resiliation' => 'resiliation', 'netadd' => 'netAdd')
        ),  
        
        'RecBTBActSynWeek' => array(
            'class' => '\AppBundle\Entity\RecBTBActSynWeek',
            'table'=> 'rec_btb_act_syn_week',
            'fields' => array('SEM', 'CUSTCODE', 'INTITULE', 'DES', 'TYPE1', 'CSCURBALANCE',
                'PREV_BALANCE', 'LBC_DATE', 'CB1', 'SUSP1', 'ACT1', 'DEAC1', 
                'ANNEE', 'GRANDCOMPTE'),
            'fields_mapping' => array(
                'SEM' => 'sem', 'CUSTCODE'=> 'custCode', 'INTITULE'=>'intitule',
                'DES'=> 'des', 'TYPE1'=>'type1', 'CSCURBALANCE' =>'cscurbalance',
                'PREV_BALANCE'=> 'prevBalance', 'LBC_DATE'=> 'lbcDate', 'CB1'=>'cb1',
                'SUSP1'=>'susp1', 'ACT1'=>'act1','DEAC1'=>'deac1','ANNEE'=>'annee','GRANDCOMPTE'=>'grandCompte'
            )
        ),
        
        'B2BSyntheseCA' => array(
          
            'class' => '\AppBundle\Entity\B2BSyntheseCA',
            'table' => 'b2b_ca_synthese',
            'fields' => array('annee','mois1', 'region', 'type_compte', 'CA1'),
            'fields_mapping' => array('annee' => 'annee', 'mois1' => 'mois',
                'region' => 'region', 'type_compte' => 'typeCompte', 'CA1' => 'ca')
        ),
        
        'B2BDesRequete' => array(
            'class' => '\AppBundle\Entity\B2BDesRequete',
            'table' => 'b2b_des_requete',
            'fields' => array('id', 'nom', 'email'),
            'fields_mapping' => array('id'=>'id', 'nom' => 'nom', 'email' => 'email'),
            'pk' => 'id'
        ),
        'B2BLigneDesRequete' => array('class' => '\AppBundle\Entity\B2BLigneDesRequete',
            'table' => 'b2b_ligne_des_requete',
            'fields' => array('id', 'id_requete', 'id_des', 'nature'),
            'fields_mapping' => array('id' => 'id', 'id_requete' => 'idRequete', 'id_des' => 'idDes', 'nature' => 'nature'),
            'pk' => 'id'
        ),
        'B2BCommentaireRequete' => array('class' => '\AppBundle\Entity\B2BCommentaireRequete',
            'table'=> 'b2b_commentaire_requete',
            'fields'=> array('id', 'id_requete', 'n_user_init', 'commentaire', 'date_commentaire', 'nom_utilisateur'),
            'fields_mapping' => array('id'=>'id', 'id_requete'=> 'idRequete', 'n_user_init'=> 'nUserInit',
            'commentaire'=> 'commentaire', 'date_commentaire'=> 'dateCommentaire', 'nom_utilisateur'=> 'nomUtilisateur'),
            'pk'=> 'id'),
        
        'B2BRequete' => array(
            'class' => '\AppBundle\Entity\B2BRequete',
            'table' => 'b2b_requete',
            'fields' => array(
                'NRequete', 'NClient', 'NAscom', 'NumeroTicket',
                'Date_reception', 'Date_transmission', 'Date_Cloture',
                'Destinataire_dsc', 'Responsable_dsc', 'Date_traitement_dsc', 'Ligne',
                'PlageNumero', 'Operation', 'Justificatif', 'Remarques_Initiales',
                'Remarques_traitement', 'NUserInit', 'NuserCloture', 'Statut', 'PJ1', 'Source',
                'Nom_Client', 'Compte_Client', 'fichiers_joints_creation', 'fichiers_joints_traitement',
                'date_creation', 'issue', 'details_issue'),
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
                'Nom_Client' => 'nomClient', 'Compte_Client' => 'compteClient',
                'fichiers_joints_creation' => 'fichiersJointsCreation',
                'fichiers_joints_traitement' => 'fichiersJointsTraitement',
                'date_creation' => 'dateCreation', 'issue' => 'issue', 'details_issue'=> 'detailsIssue'
            ),
            'pk' => 'NRequete'
        )
    );

}  