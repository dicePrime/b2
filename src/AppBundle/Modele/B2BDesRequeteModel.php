<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\B2BDesRequete;
use AppBundle\Commons\Tools;
use diceprime\Bundle\ORMBundle\AClasses\DataManager;
/**
 * Description of B2BDesRequeteModel
 *
 * @author BMHB8456
 */
class B2BDesRequeteModel {
    //put your code here
    
        
    private $connection;
    private $dataManager;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->dataManager = new DataManager("B2BDesRequete", $connection);
    }
     
    public function findAll()
    {
      return $this->dataManager->findAll();
    }
    
    /**
     * Cette fonction prend en paramètre une liste de destinataires d'une requete
     * et les retourne avec t
     * @param type $destinatairesRequete
     */
    public function findFromListeDestinataires($destinatairesRequete)
    {
        $resultat = array();
        
        foreach($destinatairesRequete as $dest)
        {
            $resultat[] = $this->dataManager->find($dest->getIdDes());
        }
    }
    
    public function findBy($fields)
    {
        return $this->dataManager->findBy($fields);
    }
    
    public function find($id)
    {
        return $this->dataManager->find($id);
    }
}
