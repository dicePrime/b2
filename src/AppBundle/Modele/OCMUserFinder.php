<?php

namespace AppBundle\Modele;

use AppBundle\Commons\Tools;

class OCMUserFinder {

    //put your code here
    //put your code here

    static function get_TNS() {
        return self::$TNS;
    }

    static function get_SCHEMA_ID() {
        return self::$SCHEMA_ID;
    }

    static function get_SCHEMA_PASS() {
        return self::$SCHEMA_PASS;
    }

    static function get_LDAP_HOST() {
        return self::$LDAP_HOST;
    }

    static function get_LDAP_DOMAIN() {
        return self::$LDAP_DOMAIN;
    }

    static function get_PROFIL_CHEF_DEPARTEMENT() {
        return self::$PROFIL_CHEF_DEPARTEMENT;
    }

    static function get_PROFIL_CHEF_SERVICE() {
        return self::$PROFIL_CHEF_SERVICE;
    }

    static function get_PROFIL_DIRECTEUR() {
        return self::$PROFIL_DIRECTEUR;
    }

    static function get_AUTH_DEFAULT() {
        return self::$AUTH_DEFAULT;
    }

    static function set_TNS($TNS) {
        self::$TNS = $TNS;
    }

    static function set_SCHEMA_ID($SCHEMA_ID) {
        self::$SCHEMA_ID = $SCHEMA_ID;
    }

    static function set_SCHEMA_PASS($SCHEMA_PASS) {
        self::$SCHEMA_PASS = $SCHEMA_PASS;
    }

    static function set_LDAP_HOST($LDAP_HOST) {
        self::$LDAP_HOST = $LDAP_HOST;
    }

    static function set_LDAP_DOMAIN($LDAP_DOMAIN) {
        self::$LDAP_DOMAIN = $LDAP_DOMAIN;
    }

    static function set_PROFIL_CHEF_DEPARTEMENT($PROFIL_CHEF_DEPARTEMENT) {
        self::$PROFIL_CHEF_DEPARTEMENT = $PROFIL_CHEF_DEPARTEMENT;
    }

    static function set_PROFIL_CHEF_SERVICE($PROFIL_CHEF_SERVICE) {
        self::$PROFIL_CHEF_SERVICE = $PROFIL_CHEF_SERVICE;
    }

    static function set_PROFIL_DIRECTEUR($PROFIL_DIRECTEUR) {
        self::$PROFIL_DIRECTEUR = $PROFIL_DIRECTEUR;
    }

    static function set_AUTH_DEFAULT($AUTH_DEFAULT) {
        self::$AUTH_DEFAULT = $AUTH_DEFAULT;
    }

    public static $TNS = 'DB_TEST';
    public static $SCHEMA_ID = 'GESOM';
    public static $SCHEMA_PASS = 'GE123SOM';
    public static $LDAP_HOST = "172.21.55.4";
    public static $LDAP_DOMAIN = "adcm.orangecm";
    public static $PROFIL_CHEF_DEPARTEMENT = 'DPT';
    public static $PROFIL_CHEF_SERVICE = 'SVCE';
    public static $PROFIL_DIRECTEUR = 'DT';

    /**
     * Cette fonction permet de donner des informations de base sur un employé connaissant son CUID
     * Les informations retournées sont : NOM, PROFIL_STAF,QUALIFICATION, EMAIL,DEPARTEMENT,SERVICE et DIRECTION
     * @param type $cuid
     * @return type
     */
    public static $AUTH_DEFAULT = false;

    public function setDefaultAuth($auth) {
        OCMUserFinder::$AUTH_DEFAULT = $auth;
    }

    public function getDefaultUser() {
        $resul = array();
        $resul['NOM'] = 'DEFAULT OCM USER';
        $resul['PROFIL'] = 'EMPLOYE';
        $resul['QUALIFICATION'] = 'USER';
        $resul['SERVICE'] = 'OSS';
        $resul['DEPARTEMENT'] = 'INGENIEURIE PFS ET SI';
        $resul['DIRECTION'] = 'DD';
        $resul['MATRICULE'] = '17062015114135';

        return $resul;
    }

    public function get_user_info($cuid) {
        if (OCMUserFinder::$AUTH_DEFAULT) {

            return $this->getDefaultUser();
        } else {
            $resul = array();

            $bdd = new \PDO('oci:dbname=172.21.13.15:1521/SIT', 'GESOM', 'GE123SOM');
            //$conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
            $sql_text = "SELECT NOM,EMAIL,PROFIL_STAF, QUALIFICATION, DEPARTEMENT ,SERVICE, DIRECTION,MATRICULE from OM_EMPLOYE where UPPER(LOGIN) = UPPER('" . $cuid . "') or UPPER(IDENTIFIANT)=  UPPER('" . $cuid . "') or LOGIN like '%$cuid%' or  UPPER(LOGIN) like UPPER('%$cuid%')";
            //$query = oci_parse($conn, $sql_text);
            $query = $bdd->prepare($sql_text);


            //oci_execute($query);
            $query->execute();
            //$row = oci_fetch_array($query, OCI_BOTH);
            $row = $query->fetch();

            Tools::writeFile("row.txt", $row);

            $resul['NOM'] = $row['NOM'];
            $resul['PROFIL'] = $row['PROFIL_STAF'];
            $resul['QUALIFICATION'] = $row['QUALIFICATION'];
            $resul['SERVICE'] = $row['SERVICE'];
            $resul['DEPARTEMENT'] = $row['DEPARTEMENT'];
            $resul['DIRECTION'] = $row['DIRECTION'];
            $resul['MATRICULE'] = $row['MATRICULE'];
            $resul['EMAIL'] = $row['EMAIL'];

            //var_dump($row);
            try {
                //oci_close($bdd);
            } catch (\Exception $exc) {
                Tools::writeFile("exceptions/getUserInfo.txt", $exc->getMessage());
            }
            return $resul;
        }
    }

    /**
     * This function is use to verify  if a user is has an account in the LDAP dictionnary 
     * @param type $cuid
     * @param type $password
     * Si la personne est authentifie et est présent dans l'annuaire alors la fonction retourne true sino retourne false
     * 
     * @return rep
     */
    public function authentify($cuid, $password) {

        try {
            if (OCMUserFinder::$AUTH_DEFAULT)
            {
                return true;
            } 
            else
            {
                if (strlen(trim($cuid)) == 0) 
                {
                    return false;
                }

                if (strlen(trim($password)) == 0)
                {
                    return false;
                }


                $host = OCMUserFinder::$LDAP_HOST;
                $domain = OCMUserFinder::$LDAP_DOMAIN;
                $ldaprdn = $cuid . "@" . $domain;
                $ldappass = $password;
                $ldapconn = ldap_connect($host, 389) or die("Could not connect to LDAP server.");
                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
                $rep = @ldap_bind($ldapconn, $ldaprdn, $ldappass);
                /* @var $ldapconn type */
                ldap_close($ldapconn);
                //var_dump($rep);
                return $rep;
            }
        } catch (\ErrorException $ex) {
            Tools::writeFile("testLdap.txt", $ex->getMessage());
            return false;
        }
    }

    /**
     * La fonction permet de retrouver toutes les informations sur un individu
     * <br/>Exemple : $row['IDENTIFIANT'] renvoie l'identifiant de l'employe dont le CUID est passé en parametre
     * <br/> Quelques champs utiles : MATRICULE,QUALIFICATION,DEPARTEMENT,SERVICE,REGION,LOGIN,PASSWORD,PROFIL_STAFF,PROFIL_USER,GROUPE_PORTAIL,EMAIL,DATE_DEBUT,MAGASIN
     * @param type $cuid
     * @return type
     */
    public function getAlluserInformation($cuid) {

        $conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT * from OM_EMPLOYE where UPPER(login) = '" . $cuid . "' or UPPER(identifiant)= '" . $cuid . "' or login like '%$cuid%'";
        $query = oci_parse($conn, $sql_text);

        oci_execute($query);
        $row = oci_fetch_array($query, OCI_BOTH);
        //var_dump($row);
        try {
            oci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }

    /**
     * Cette fonction retourne tous les CUID des employés
     * <br/>Exemple : $row['IDENTIFIANT'][10] renvoie l'identifiant du 10 ième employé dans le schéma
     * @return type
     */
    public function getAllCuid() {
        $conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT IDENTIFIANT from OM_EMPLOYE";
        $query = oci_parse($conn, $sql_text);

        $row = array();
        oci_execute($query);
        $value = oci_fetch_all($query, $row);

        //var_dump($value);
        //var_dump($row['IDENTIFIANT'][10]);
        try {
            oci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }


    public function getAllOCMUsers()
    {
        $bdd = new \PDO('oci:dbname=172.21.13.15:1521/SIT', 'GESOM', 'GE123SOM');
       //conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT * FROM OM_EMPLOYE order by NOM";
        $query = $bdd->prepare($sql_text);
        $query->execute();
       

        $resultat = array();

       /*ci_execute($query);
        $value = oci_fetch_all($query, $row);
        //var_dump($row);
        //var_dump($value);*/
        while($row = $query->fetch())
        {
            $resultat[] = $row;
        }
       


        try {
           //ci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $resultat;
    }

    /**
     * 
     * @param type $cuid
     */
    public function getChiefWithFunction($cuid) {
        
    }

    /**
     * Cette fonction permet de retrouver tous les employés d'un domaine spécifique
     * @param type $domaine_condition On pourra avoir ('INGENIEURIE PFS ET SI','ADMINISTRATION DF')
     * @param type $domaine_type DEPARTEMENT
     */
    public function getUserOfDomain($domaine_condition, $domaine_type) {
        $conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT MATRICULE,NOM,QUALIFICATION,REGION,PROFIL_USER,EMAIL, DEPARTEMENT, SERVICE from OM_EMPLOYE where $domaine_type IN ($domaine_condition) and ETAT_COMPTE='Actif' order by NOM";
        $query = oci_parse($conn, $sql_text);
//echo $sql_text;
        $row = array();
        oci_execute($query);
        $value = oci_fetch_all($query, $row);
        //var_dump($row['NOM'][254]);
        //var_dump($value);

        try {
            oci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }

    /**
     * Etant donné le CUID d'un utilisateur, cette fonction permet de retrouver les informations du chef de département d'un utilisateur
     * @param type $cuid
     * @return type
     */
    public function getDeptChiefOfUser($matricule) {

        $bdd = new \PDO('oci:dbname=172.21.13.15:1521/SIT', 'GESOM', 'GE123SOM');
       //conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT NOM,REGION,MATRICULE,EMAIL, DEPARTEMENT, SERVICE FROM OM_EMPLOYE WHERE DEPARTEMENT=(SELECT DEPARTEMENT FROM OM_EMPLOYE WHERE MATRICULE like '%$matricule%') and PROFIL_USER='" . OCMUserFinder::$PROFIL_CHEF_DEPARTEMENT . "'";
        $query = $bdd->prepare($sql_text);
        $query->execute();
       

       /*ci_execute($query);
        $value = oci_fetch_all($query, $row);
        //var_dump($row);
        //var_dump($value);*/
        $row = $query->fetch();


        try {
           //ci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }


    public function getUserByMatricule($matricule) {
        $bdd = new \PDO('oci:dbname=172.21.13.15:1521/SIT', 'GESOM', 'GE123SOM');
       //conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT MATRICULE,NOM,REGION,EMAIL, DEPARTEMENT, SERVICE FROM OM_EMPLOYE WHERE  MATRICULE like '%$matricule%'";
        $query = $bdd->prepare($sql_text);
        $query->execute();

       /*row = array();
       //ci_execute($query);
        $value = oci_fetch_all($query, $row);
        //var_dump($row);
        //var_dump($value);*/
        $row = $query->fetch();

        try {
            //i_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }


    /**
     * Cette fonction permet de retrouver directement le directeur de rattachement d'un employé
     * @param type $cuid
     * @return array
     */
    public function getDirChiefOfUser($matricule) {
        $bdd = new \PDO('oci:dbname=172.21.13.15:1521/SIT', 'GESOM', 'GE123SOM');
       //conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT MATRICULE,NOM,REGION,EMAIL, DEPARTEMENT, SERVICE FROM OM_EMPLOYE WHERE DIRECTION=(SELECT DIRECTION FROM OM_EMPLOYE WHERE MATRICULE like '%$matricule%') and PROFIL_USER='" . OCMUserFinder::$PROFIL_DIRECTEUR . "'";
        $query = $bdd->prepare($sql_text);
        $query->execute();

       /*row = array();
       //ci_execute($query);
        $value = oci_fetch_all($query, $row);
        //var_dump($row);
        //var_dump($value);*/
        $row = $query->fetch();

        try {
            //i_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }

    /**
     * 
     * @param type $name Le nom de l'utilisateur on veut les informations
     */
    public function getUserByName($name) {
        $name = strtoupper($name);
        $conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT distinct(NOM),QUALIFICATION,REGION,DEPARTEMENT, SERVICE,PROFIL_USER,EMAIL,DIRECTION,MATRICULE from OM_EMPLOYE where UPPER(NOM) like UPPER('%$name%') ";
        $query = oci_parse($conn, $sql_text);

        $row = array();
        oci_execute($query);
        $value = oci_fetch_all($query, $row);


        try {
            oci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }

    public function getUserByCharacter($character, $valeur) {

        $conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $sql_text = "SELECT MATRICULE,NOM,QUALIFICATION,REGION,PROFIL_USER,EMAIL from OM_EMPLOYE where $character like '%$valeur%' ";
        $query = oci_parse($conn, $sql_text);

        $row = array();
        oci_execute($query);
        $value = oci_fetch_all($query, $row);


        try {
            oci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }

    /**
     * Cette fonction permet de trouver les informations sur le chef de service d'un employé. Il est important de savoir que le chef de service c'est par région
     * @param type $cuid
     * @return row Ce tableau contient les informations du chef de service de la personne dont le cuid est passé en parametre
     */
    public function getServChiefOfUser($matricule) {
        //$conn = oci_connect(OCMUserFinder::$SCHEMA_ID, OCMUserFinder::$SCHEMA_PASS, OCMUserFinder::$TNS);
        $bdd = new \PDO('oci:dbname=172.21.13.15:1521/SIT', 'GESOM', 'GE123SOM');
        $sql_text = "SELECT NOM,REGION,EMAIL,MATRICULE, DEPARTEMENT, SERVICE FROM OM_EMPLOYE WHERE SERVICE=(SELECT SERVICE FROM OM_EMPLOYE WHERE MATRICULE like '%$matricule%') AND REGION=(SELECT REGION FROM OM_EMPLOYE WHERE MATRICULE like '%$matricule%') and PROFIL_USER='" . OCMUserFinder::$PROFIL_CHEF_SERVICE . "'";
        $query = $bdd->prepare($sql_text);
        $query->execute();

        $row = array();
       // oci_execute($query);
        //$value = oci_fetch_all($query, $row);
        //var_dump($row);
        //var_dump($value);
        $row = $query->fetch();

        try {
           //ci_close($conn);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        return $row;
    }

    public function test_fonctionnalite() {
        //var_dump('test auth');
        $this->authentify('takwa', 'Orange2015');
        //var_dump('test auth');
        $this->authentify('takw', 'Orange2015');
        //var_dump('test all cuid');
        $this->getAllCuid();

        $user_cuid = 'takwa';
        //var_dump('test chef dep');
        //$this->getChiefWithFunction($user_cuid);

        $this->getDeptChiefOfUser($user_cuid);
        //var_dump('test all info');
        $this->getAlluserInformation($user_cuid);
        //var_dump('test chef serv');
        $this->getServChiefOfUser($user_cuid);
        //var_dump('test utilisateur domaine');
        $this->getUserOfDomain('\'DO\'', 'DIRECTION');
        $this->get_user_info($user_cuid);
        //var_dump('test directeur');
        $this->getDirChiefOfUser($user_cuid);
    }

    public function justtotestifloaded() {
        echo 'loaded';
    }

}
