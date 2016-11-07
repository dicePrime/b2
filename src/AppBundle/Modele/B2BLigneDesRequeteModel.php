<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

/**
 * Description of B2BLigneDesRequeteModel
 *
 * @author BMHB8456
 */
class B2BLigneDesRequeteModel {
    //put your code here
    
    public static $_GET_LIGNES_DES_REQUETES_FOR_REQUETE = "SELECT * FROM b2b_ligne_des_requete where id_requete = :idRequete";
    
    public static $_INSERT_INTO_LIGNE_DES_REQUETE = "INSERT INTO b2b_ligne_des_requete(id_res, id_requete) values(:idRes, :idRequete)";
    
    //public static $_UPDATE_LIGNE_DES_REQUETE = "UPDATE b2b_ligne_des_requete set id_res =: idRes, id_requete"
}
