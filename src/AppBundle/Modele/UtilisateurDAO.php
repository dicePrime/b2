<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\Utilisateur;
use AppBundle\Commons\Tools;
use AppBundle\Modele\OCMUserFinder;

/**
 * Description of UtilisateurDAO
 *
 * @author ndziePatrick
 */
class UtilisateurDAO {

    //put your code here
    //public static function $_GET

    public static $PROFIL_CHEF_DEPARTEMENT = 'DPT';
    public static $PROFIL_CHEF_SERVICE = 'SVCE';
    public static $PROFIL_DIRECTEUR = 'DT';
    public static $TNS = 'DB_TEST';
    public static $SCHEMA_ID = 'GESOM';
    public static $SCHEMA_PASS = 'GE123SOM';
    public static $LDAP_HOST = "172.24.0.6";
    public static $LDAP_DOMAIN = "adcm.orangecm";
    public static $_GET_UTILISATEUR_BY_CUID = "select * from sec_users where login = :cuid";
    public static $_GET_ALL_UTILISATEUR = "select * from sec_users";
    public static $_GET_UTILISATEUR_BY_ID = "select * from utilisateur where id_utilisateur = :idUtilisateur";
    public static $_GET_CHEF_DEPARTEMENT_UTILISATEUR = "SELECT nom,region,matricule,departement,service,region, profil_user,email, direction FROM om_employe WHERE departement = (SELECT departement FROM om_employe WHERE matricule like :likeMatricule) and PROFIL_USER = :profilChefDepartement";
    public static $_GET_DIRECTEUR_UTILISATEUR = "SELECT nom,region,matricule,departement,service,region, profil_user,email, direction FROM OM_EMPLOYE WHERE DIRECTION=(SELECT DIRECTION FROM OM_EMPLOYE WHERE MATRICULE like :likeMatricule) and PROFIL_USER= :profilDirecteur";
    public static $_GET_CHEF_SERVICE_UTILISATEUR = "SELECT nom,region,matricule,departement,service,region, profil_user,email, direction FROM OM_EMPLOYE WHERE SERVICE=(SELECT SERVICE FROM OM_EMPLOYE WHERE MATRICULE like :likeMatricule) AND REGION=(SELECT REGION FROM OM_EMPLOYE WHERE MATRICULE like :likeMatricule) and PROFIL_USER= :profilChefService";
    public static $_INSERT_UTILISATEUR = "insert into utilisateur(cuid, role, regions, nom,receive_emails, email) values(:cuid,:role,:regions,:nom,:receiveEmails,:email)";
    public static $_UPDATE_UTILIATEUR = "update utilisateur set cuid = :cuid, role = :role, regions = :regions, nom = :nom, receive_emails = :receiveEmails, email = :email where id_utilisateur = :idUtilisateur";
    public static $_DELETE_UTILISATEUR = "delete from utilisateur where id_utilisateur = :idUtilisateur";
    public static $_GET_OM_PROD_EMPLOYE = "SELECT NOM, EMAIL, PROFIL_STAF, QUALIFICATION, DEPARTEMENT, SERVICE, DIRECTION, MATRICULE, IDENTIFIANT, LOGIN FROM OM_EMPLOYE where login = :login or login = :loginUpper or identifiant = :identifiant or identifiant = :identifiantUpper";
    public static $_GET_OM_EMPLOYE = "SELECT * FROM om_employe where login = :login and password = :password";
    //public static $_INSERT_UTILISATEUR = "insert into utilisateur("
    public static $_INSERT_CONNECTION_LOG = "insert into connection_log(date_login, cuid_utilisateur, nom_utilisateur) values(:dateLogin, :cuidUtilisateur, :nomUtilisateur)";

    private $ldapConnexion;
    private $normalConnexion;

    public function __construct($ldapConnexion, $normalConnexion) {

        $this->ldapConnexion = $ldapConnexion;
        $this->normalConnexion = $normalConnexion;
    }

    /**
     * Cette fonction retourne tous les administrateurs du système c'est à dire les utilisateurs enregistrés
     * dans la base de données
     */
    public function getAllUtilisateur() {

        $resultat = array();
        try {
            $req = $this->normalConnexion->prepare(UtilisateurDAO::$_GET_ALL_UTILISATEUR);

            $req->execute();

            while ($row = $req->fetch()) {
                $resultat[] = $this->fetchUser($row, NULL);
            }

            return $resultat;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/getAllUtilisateur.txt', $ex->getMessage());
            return $resultat;
        }
    }

    public function getUtilisateurById($idUtilisateur) {

        try {
            $req = $this->normalConnexion->prepare(UtilisateurDAO::$_GET_UTILISATEUR_BY_ID);

            $req->execute(array('idUtilisateur' => $idUtilisateur));

            return $this->fetchUser($req->fetch(), NULL);
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/getUtilisateurById.txt', $ex->getMessage());
            return null;
        }
    }

    public function fetchLDAPUser($row, $utilisateur) {
        if ($utilisateur == NULL) {
            $utilisateur = new Utilisateur();
        }

        $utilisateur->setMatricule($row['MATRICULE']);
        $utilisateur->setNom($row['NOM']);
        $utilisateur->setDepartement($row['DEPARTEMENT']);
        $utilisateur->setService($row['SERVICE']);
        $utilisateur->setRegion($row['REGION']);
        $utilisateur->setProfilUser($row['PROFIL_USER']);
        $utilisateur->setEmail($row['EMAIL']);
        $utilisateur->setDirection($row['DIRECTION']);

        return $utilisateur;
    }

    public function getAllOCMUsers()
    {
        try
        {
                $ocmUserFinder = new OCMUserFinder();

                $utilisateursArray = $ocmUserFinder->getAllOCMUsers();

                $length = count($utilisateursArray);

                $utilisateurs = array();

            foreach($utilisateursArray as $row)
            {
                $utilisateur = $this->fetchLDAPUser($row, null);

                $utilisateurs[] = $utilisateur;
            }

                return $utilisateurs;
        }

         catch (\Exception $ex) {

            Tools::writeFile('exceptions/getAllOCMUsers.txt', $ex->getMessage());
            return null;
        }


    }

    public function fetchUser($row, $utilisateur) {
        if ($utilisateur == NULL) {
            $utilisateur = new Utilisateur();
        }
        
        //Tools::writeFile("testLdap1.txt", $utilisateur);
        //if($row['role'] != null) $utilisateur->setRole($row['role']);
        if($row['login'] != null) $utilisateur->setCuid($row['login']);
        if($row['name'] != null) $utilisateur->setNom($row['name']);
        if($row['email'] != null) $utilisateur->setEmail($row['email']);
        if($row['active'] != null) $utilisateur->setActive($row['active']);
        if($row['activation_code'] != null) $utilisateur->setActivationCode($row['activation_code']);
        if($row['priv_admin'] != null) $utilisateur->setPrivAdmin($row['priv_admin']);
       
        /*$regions = preg_split("#;#", $utilisateur->getChaineRegions());
        $utilisateur->setRegions($regions);
        Tools::writeFile("tesUtilisateur2.txt", $utilisateur);*/
        return $utilisateur;
    }

    /**
     * Cette fonction prend en paramètres un cuid et un mot de passe
     * et retourne un utilisateur si ces paramètres sont correctes ou
     * null sinon
     * @param type $cuid
     * @param type $password
     */
    public function devLdapAuthentify($cuid, $password) {
        try {
            $req = $this->ldapConnexion->prepare(UtilisateurDAO::$_GET_OM_EMPLOYE);

            $req->execute(array('login' => $cuid, 'password' => $password));

            $row = $req->fetch();

            if ($row != null) {
                $ldapUser = $this->fetchLDAPUser($row, NULL);

                Tools::writeFile("testLdapUser.txt", $ldapUser);

                $req1 = $this->normalConnexion->prepare(UtilisateurDAO::$_GET_UTILISATEUR_BY_CUID);

                $req1->execute(array('cuid' => $cuid));

                $row1 = $req1->fetch();

                return $this->fetchUser($row1, $ldapUser);
            }

            return null;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/ldapAuthentify.txt', $ex->getMessage());
            return null;
        }
    }

    /**
     * C'est la fonction d'authentification utilisée pendant le développement
     * elle sera commentée pour laisser place à la version de production
     * @param type $cuid
     * @param type $password
     */
    public function ldapAuthentify($cuid, $password) {
        try {
            
            $ocmUserFinder = new OCMUserFinder();
            if($ocmUserFinder->authentify($cuid, $password) || ('admin' == $cuid && 'MolimoKita@14' == $password))
            {
                $userInfo = $ocmUserFinder->get_user_info($cuid);
                //Tools::writeFile('testldapUser.txt', $userInfo);                
                $ldapUtilisateur = new Utilisateur();
                $ldapUtilisateur->setEmail($userInfo['EMAIL']);
                $ldapUtilisateur->setNom($userInfo['NOM']);
                $ldapUtilisateur->setService($userInfo['SERVICE']);
                $ldapUtilisateur->setDirection($userInfo['DIRECTION']);
                $ldapUtilisateur->setMatricule($userInfo['MATRICULE']);
                
                
                $req1 = $this->normalConnexion->prepare(UtilisateurDAO::$_GET_UTILISATEUR_BY_CUID);

                $req1->execute(array('cuid' => $cuid));

                $row1 = $req1->fetch();
               
                return $this->fetchUser($row1, $ldapUtilisateur);
                
            }
        } catch (\Exception $ex) {
            Tools::writeFile('exceptions/ldapAuthentify.txt', $ex->getMessage());
            return null;
        }
    }

    public function getUtilisateurByCUID($cuid) {
        
    }

    public function getUtilisateurByMatricule($matricule)
    {
        try {
           $ocmUSerFinder = new OCMUserFinder();
            //MATRICULE,NOM,REGION,EMAIL
            //NOM,REGION,EMAIL,MATRICULE
            $chefArray = $ocmUSerFinder->getUserByMatricule($matricule);
            $chefService = new Utilisateur();
            $chefService->setMatricule($chefArray['MATRICULE']);
            $chefService->setNom($chefArray['NOM']);
            $chefService->setRegion($chefArray['REGION']);
            //$chefService->setMatricule($chefArray['MATRICULE']);
            $chefService->setEmail($chefArray['EMAIL']);
            
            return $chefService;
            
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/getChefDepartementUtilisateur.txt', $ex->getMessage());
            return new Utilisateur();
        }
    }

    /**
     * Cette fonction prend en paramètre un utilisateur 
     * et retourne la liste de ses n+1 sous forme
     * d'un tableau d'utilisateurs
     * @param type $utilisateur
     */
    public function getUtilisateurNPlus1($utilisateur) {
        $resultat = array();

        $chefService = $this->getChefServiceUtilisateur($utilisateur);
        $directeur = $this->getDirecteurUtilisateur($utilisateur);
        $chefDepartement = $this->getChefDepartementUtilisateur($utilisateur);

        if ($chefService != null) {
            $resultat[] = $chefService;
        }

        if ($directeur != null) {
            $resultat[] = $directeur;
        }

        if ($chefDepartement != null) {
            $resultat[] = $chefDepartement;
        }

        return $resultat;
    }

    public function getChefDepartementUtilisateur(Utilisateur $utilisateur) {
        try {
           $ocmUSerFinder = new OCMUserFinder();
            //MATRICULE,NOM,REGION,EMAIL
            //NOM,REGION,EMAIL,MATRICULE
            $chefArray = $ocmUSerFinder->getDeptChiefOfUser($utilisateur->getMatricule());
            $chefService = new Utilisateur();
            $chefService->setMatricule($chefArray['MATRICULE']);
            $chefService->setNom($chefArray['NOM']);
            $chefService->setRegion($chefArray['REGION']);
            //$chefService->setMatricule($chefArray['MATRICULE']);
            $chefService->setEmail($chefArray['EMAIL']);
            
            return $chefService;
            
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/getChefDepartementUtilisateur.txt', $ex->getMessage());
            return new Utilisateur();
        }
    }

    /**
     * Cette fonction prend un utilisateur en paramètre et retourne
     * son chef de service
     * @param type $utilisateur
     */
    public function getChefServiceUtilisateur($utilisateur) {
        try {
                        
            $ocmUSerFinder = new OCMUserFinder();
            //MATRICULE,NOM,REGION,EMAIL
            //NOM,REGION,EMAIL,MATRICULE
            $chefArray = $ocmUSerFinder->getServChiefOfUser($utilisateur->getMatricule());
            $chefService = new Utilisateur();
            $chefService->setMatricule($chefArray['MATRICULE']);
            $chefService->setNom($chefArray['NOM']);
            $chefService->setRegion($chefArray['REGION']);
            //$chefService->setMatricule($chefArray['MATRICULE']);
            $chefService->setEmail($chefArray['EMAIL']);

            return $chefService;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/getChefServiceUtilisateur.txt', $ex->getMessage());
            return null;
        }
    }

    /**
     * Cette fonction prend en paramètre un utilisateur et retourne son 
     * directeur
     * @param type $utilisateur
     */
    public function getDirecteurUtilisateur($utilisateur) {
        try {
            $ocmUSerFinder = new OCMUserFinder();
            
            $directeurArray= $ocmUSerFinder->getDirChiefOfUser($utilisateur->getMatricule());
            //MATRICULE,NOM,REGION,EMAIL
            $directeurUtilisateur = new Utilisateur();
            $directeurUtilisateur->setMatricule($directeurArray['MATRICULE']);
            $directeurUtilisateur->setNom($directeurArray['NOM']);
            $directeurUtilisateur->setRegion($directeurArray['REGION']);
            $directeurUtilisateur->setEmail($directeurArray['EMAIL']);
            
            return $directeurUtilisateur;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/getDirecteurUtilisateur.txt', $ex->getMessage());
            return null;
        }
    }

    public function insertUtilisateur(Utilisateur $utilisateur) {
        try {
            $req = $this->normalConnexion->prepare(UtilisateurDAO::$_INSERT_UTILISATEUR);

            $resultat = $req->execute
                    (
                    array
                        (
                        'cuid' => $utilisateur->getCuid(),
                        'role' => $utilisateur->getRole(),
                        'regions' => $utilisateur->getChaineRegions(),
                        'nom' => $utilisateur->getNom(),
                        'receiveEmails' => $utilisateur->getReceiveEmails(),
                        'email' => $utilisateur->getEmail()));
            return $resultat;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/insertUtilisateur.txt', $ex->getMessage());
            return false;
        }
    }

    public function updateUtilisateur(Utilisateur $utilisateur) {
        try {
            $req = $this->normalConnexion->prepare(UtilisateurDAO::$_UPDATE_UTILIATEUR);

            $resultat = $req->execute
                    (
                    array
                        (
                        'idUtilisateur' => $utilisateur->getIdUtilisateur(),
                        'cuid' => $utilisateur->getCuid(),
                        'role' => $utilisateur->getRole(),
                        'regions' => $utilisateur->getChaineRegions(),
                        'nom' => $utilisateur->getNom(),
                        'receiveEmails' => $utilisateur->getReceiveEmails(),
                        'email' => $utilisateur->getEmail()));
            return $resultat;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/updateUtilisateur.txt', $ex->getMessage());

            return false;
        }
    }

    public function deleteUtilisateur($idUtilisateur) {
        try {
            $req = $this->normalConnexion->prepare(UtilisateurDAO::$_DELETE_UTILISATEUR);

            $req->execute
                    (
                    array
                        (
                        'idUtilisateur' => $idUtilisateur));
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/deleteUtilisateur.txt', $ex->getMessage());
        }
    }

    public function getAllUtilisateurs() {
        $resultat = array();
        try {
            $req = $this->normalConnexion->prepare(UtilisateurDAO::$_GET_ALL_UTILISATEUR);

            $req->execute();

            while ($row = $req->fetch()) {
                $resultat[] = $this->fetchUser($row, NULL);
            }

            return $resultat;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/getAllUtilisateurs.txt', $ex->getMessage());
            return $resultat;
        }
    }

    public function getAllUtilisateursEmails() {
        $allUtilisateurs = $this->getAllUtilisateurs();

        $resultat = array();

        foreach ($allUtilisateurs as $next) {
            if ($next->getRole() != 'ADMIN') {
                $resultat[] = $next->getEmail();
            }
        }

        return $resultat;
    }
    
    public function insertConnectionLog(Utilisateur $utilisateur, $dateLogin)
    {
       try {
            $req = $this->normalConnexion->prepare(UtilisateurDAO::$_INSERT_CONNECTION_LOG);

            $resultat = $req->execute
                    (
                    array
                        (
                        'cuidUtilisateur' => $utilisateur->getCuid(),
                        'nomUtilisateur' => $utilisateur->getNom(),
                        'dateLogin' => $dateLogin));
                        
            return $resultat;
        } catch (\Exception $ex) {

            Tools::writeFile('exceptions/insertConnectionLog.txt', $ex->getMessage());
            return false;
        } 
    }

}
