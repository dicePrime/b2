<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of b2bCommentaireRequete
 *
 * @author BMHB8456
 */
class B2BCommentaireRequete {
    //put your code here
    
    private $id;
    private $idRequete;
    private $nUserInit;
    private $commentaire;
    private $dateCommentaire;
    private $nomUtilisateur;
    
    function getId() {
        return $this->id;
    }

    function getIdRequete() {
        return $this->idRequete;
    }

    function getNUserInit() {
        return $this->nUserInit;
    }

    function getCommentaire() {
        return $this->commentaire;
    }

    function getDateCommentaire() {
        return $this->dateCommentaire;
    }

    function getNomUtilisateur() {
        return $this->nomUtilisateur;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdRequete($idRequete) {
        $this->idRequete = $idRequete;
    }

    function setNUserInit($nUserInit) {
        $this->nUserInit = $nUserInit;
    }

    function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    function setDateCommentaire($dateCommentaire) {
        $this->dateCommentaire = $dateCommentaire;
    }

    function setNomUtilisateur($nomUtilisateur) {
        $this->nomUtilisateur = $nomUtilisateur;
    }
    
    public function setData($array)
    {
        if(isset($array['id']))
        {
            $this->setId($array['id']);
        }
        $this->setIdRequete($array['id_requete']);
        $this->setNUserInit($array['n_user_init']);
        $this->setCommentaire($array['commentaire']);
        $this->setDateCommentaire($array['date_commentaire']);
        $this->setNomUtilisateur($array['nom_utilisateur']);
    }


}
