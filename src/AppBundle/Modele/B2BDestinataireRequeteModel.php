<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

/**
 * Description of B2BDestinataireRequeteModel
 *
 * @author BMHB8456
 */
class B2BDestinataireRequeteModel {
    //put your code here
    
    public static $_INSERT_INTO_B2B_DESTINATAIRE_REQUTE= "insert into b2b_destinataire_requte(nom, email, nature) values(:nom, :email, :nature)";

    private $connection;
    
    public function __construct($connection) {
        
        $this->connection = $connection;
    }
    
    //public function findAllB2BDestinatairesRequete
}
