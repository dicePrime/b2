<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;



/**
 * Description of B2BParcHebdoModele
 *
 * @author BMHB8456
 */

use AppBundle\Commons\Tools;
use AppBundle\Entity\B2BParcHebdo;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;

class B2BParcHebdoModele {
    //put your code here
    
    private $connection;
    private $dataManager;

    public function __construct($connection) {

        $this->connection = $connection;
        $this->dataManager = new DataManager("B2BParcHebdo", $connection);
    }
    
    
    public function evolutionHebdo($annee)
    {
        
    }
    
    
    
    public function syntheseHebdo()
    {
        $resultat = array('synthese' => array(),
            'annees'=> array(),
            'types'=> array(),
            'semaines' => array());
        
        $datas = $this->dataManager->findAll();
        
        
        
        foreach($datas as $data)
        {
            
          
          if(!in_array($data->getAnnee(), $resultat['annees']))
          {
              $resultat['annees'][] = $data->getAnnee();
          }
          
          if(!in_array($data->getType(), $resultat['types']))
          {
              $resultat['types'][] = $data->getType();
          }
          
          if(isset($resultat['semaines'][$data->getAnnee()]))
          {
              if(!in_array($data->getSemaine(), $resultat['semaines'][$data->getAnnee()]))
              $resultat['semaines'][$data->getAnnee()][] = $data->getSemaine();
          }
          else
          {
             $resultat['semaines'][$data->getAnnee()][] = $data->getSemaine(); 
          }
          
          
          $resultat['synthese'][$data->getAnnee()][$data->getSemaine()][$data->getType()]['PARC'] = $data->getParc();  
          
          $resultat['synthese'][$data->getAnnee()][$data->getSemaine()][$data->getType()]['ACTIVATION'] = $data->getActivation();  
          
          $resultat['synthese'][$data->getAnnee()][$data->getSemaine()][$data->getType()]['RESILIATION'] = $data->getResiliation(); 
          
          $resultat['synthese'][$data->getAnnee()][$data->getSemaine()][$data->getType()]['NETADD'] = $data->getNetAdd();
          
          $resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['ACTIVATION'] = 
          isset($resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['ACTIVATION']) ?
          $resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['ACTIVATION'] + $data->getActivation(): 0.0;
          
          $resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['RESILIATION'] = 
          isset($resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['RESILIATION']) ?
          $resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['RESILIATION'] + $data->getRESILIATION(): 0.0;
          
          $resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['NETADD'] = 
          isset($resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['NETADD']) ?
          $resultat['synthese'][$data->getAnnee()]['TOTAL'][$data->getType()]['NETADD'] + $data->getNetAdd(): 0.0;
          
           
        }
        
        
        foreach($resultat['annees'] as $annee)
        {
        /// $resultat['synthese'][$data->getAnnee()][$data->getSemaine()][$data->getType()]['PARC'] + $data->getParc(); 
                  
          $previousSemaine = "00";
          foreach($resultat['semaines'][$annee] as $semaine)
          {
          $resultat['synthese'][$annee][$semaine]['TOTAL']['PARC'] = 
                  $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC'] +
                  $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC'];
          
          $resultat['synthese'][$annee][$semaine]['TOTAL']['ACTIVATION'] = 
                  $resultat['synthese'][$annee][$semaine]['INTERNET']['ACTIVATION'] +
                  $resultat['synthese'][$annee][$semaine]['MOBILE']['ACTIVATION'];
          
          $resultat['synthese'][$annee][$semaine]['TOTAL']['RESILIATION'] = 
                  $resultat['synthese'][$annee][$semaine]['INTERNET']['RESILIATION'] +
                  $resultat['synthese'][$annee][$semaine]['MOBILE']['RESILIATION'];
          
          $resultat['synthese'][$annee][$semaine]['TOTAL']['NETADD'] = 
                  $resultat['synthese'][$annee][$semaine]['INTERNET']['NETADD'] +
                  $resultat['synthese'][$annee][$semaine]['MOBILE']['NETADD'];
          
          
          if($previousSemaine < $semaine)
          {
              $resultat['synthese'][$data->getAnnee()]['TOTAL']['PARC'] =  
                      $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC'] +
                  $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC'];
              
              $resultat['synthese'][$data->getAnnee()]['TOTAL']['MOBILE']['PARC'] =  
                      $resultat['synthese'][$annee][$semaine]['MOBILE']['PARC'];
              
              $resultat['synthese'][$data->getAnnee()]['TOTAL']['INTERNET']['PARC'] =  
                      $resultat['synthese'][$annee][$semaine]['INTERNET']['PARC'];
                 
          }
          $previousSemaine = $semaine;
           
          }
          
          $resultat['synthese'][$annee]['TOTAL']['ACTIVATION'] = 
                  $resultat['synthese'][$annee]['TOTAL']['INTERNET']['ACTIVATION']+
                  $resultat['synthese'][$annee]['TOTAL']['MOBILE']['ACTIVATION'];
          
          $resultat['synthese'][$annee]['TOTAL']['RESILIATION'] = 
                  $resultat['synthese'][$annee]['TOTAL']['INTERNET']['RESILIATION']+
                  $resultat['synthese'][$annee]['TOTAL']['MOBILE']['RESILIATION'];
          
          $resultat['synthese'][$annee]['TOTAL']['NETADD'] = 
                  $resultat['synthese'][$annee]['TOTAL']['INTERNET']['NETADD']+
                  $resultat['synthese'][$annee]['TOTAL']['MOBILE']['NETADD'];
          
        
          
          //Total des activation, résiliations, netadd par année et par type
          
          
        }
        
        return $resultat;
        
    }
    
    
}
