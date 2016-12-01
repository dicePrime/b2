<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Modele;

use AppBundle\Entity\ListingCA;
use AppBundle\Commons\Tools;

/**
 * Description of ListingCAModel
 *
 * @author BMHB8456
 */
class ListingCAModel {

    //put your code here

    public static $_GET_ALL_REC_BTB_CA = "select * from rec_btb_ca limit 0, 10";
    public static $_GET_REC_BTB_CA_BY_DEBUT = "select * from rec_btb_ca where periode >= :periode";
    public static $_GET_REC_BTB_CA_BY_FIN = "select * from rec_btb_ca where periode <= :periode";
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN = "select * from rec_btb_ca where periode >= :debut and periode <= :fin";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_PERIODE_ASC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by periode asc LIMIT :begin, :size";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_PERIODE_DESC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by periode desc LIMIT :begin, :size";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CLIENT_ASC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by client asc LIMIT :begin, :size";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CLIENT_DESC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by client desc LIMIT :begin, :size";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CA_ASC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by ca asc LIMIT :begin, :size";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CA_DESC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by ca desc LIMIT :begin, :size";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_COMMERCIAL_ASC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by commercial asc LIMIT :begin, :size";
    
    public static $_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_COMMERCIAL_DESC = "select * from rec_btb_ca where periode >= :debut and periode <= :fin order by commercial desc LIMIT :begin, :size";
        
    public static $_MIN_PERIODE = "201412";
    
    public static $_MAX_PERIODE = "202012";
    
    private $connection;

    public function __construct($connection) {

        $this->connection = $connection;
    }

    public function fetchListingCA($row) {

        $resultat = new ListingCA();
        try {
            $resultat->setPeriode($row['PERIODE']);
            $resultat->setClient($row['CLIENT']);
            $resultat->setCompte($row['COMPTE']);
            $resultat->setCa($row['CA']);
            $resultat->setCommercial($row['COMMERCIAL']);
            $resultat->setRegion($row['REGION']);
            $resultat->setGrandCompte($row['GRANDCOMPTE']);

            return $resultat;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/fetchListingCA.txt", $ex->getMessage());
            return $resultat;
        }
    }
    
    public function findByDebutAndFin($debut, $fin)
    {
      try {
            //$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $params = array();
            if ($debut != null && $fin != null) 
            {                   
                $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN);
                $req->bindValue('debut', $debut);
                $req->bindValue('fin', $fin); 
                              
            } 
            else {
                if ($debut != null && null == $fin) {
                    $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT);
                    $req->bindValue('periode', $debut);
                } else if (null == $debut && null != $fin) {
                    $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_FIN);
                    $req->bindValue('periode', $fin);
                } else {
                    return $this->findAll();
                }
            }
    
            
            $req->execute();

            $resultat = array();

            while ($row = $req->fetch()) {
                $resultat[] = $this->fetchListingCA($row);
            }

            return $resultat;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/findByDebutAndFin.txt", $ex->getMessage()."\n\n".$ex->getTraceAsString());
            return array();
        }  
    }
    
    public function jTableFind($debutPeriode, $finPeriode, $begin, $end, $sorting, $searchArray)
    {
        $conditions = array();
        
        $debut = $debutPeriode != null ? $debutPeriode : ListingCAModel::$_MIN_PERIODE;
        $fin = $finPeriode != null ? $finPeriode: ListingCAModel::$_MAX_PERIODE;
        
        $conditions = array(
            array('champ'=>'periode', 'condition'=> '>=', 'valeur' => $debut),
            array('champ'=>'periode', 'condition'=> '<=', 'valeur'=> $fin));
        
        $sWhere = " periode >= "
        
        $orderBy = $sorting;
        
       
        
    }

    public function findByDebutAndFinAndLimitedAndSorted($debut, $fin, $begin, $end,$sorting) {
        try {
            //$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $params = array();
            if ($debut != null && $fin != null) 
            {
                switch($sorting)
                {      
                    case "periode ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_PERIODE_ASC);
                        break;
                    case "periode DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_PERIODE_DESC);
                        break;
                    case "client ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CLIENT_ASC);
                        break;
                    case "client DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CLIENT_DESC);
                        break;
                    case "commercial ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_COMMERCIAL_ASC);
                        break;
                    case "commercial DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_COMMERCIAL_DESC);
                        break;
                    case "ca ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CA_ASC);
                        break;
                    case "ca DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_CA_DESC);
                        break;
                    default:
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_AND_FIN_ORDER_BY_PERIODE_ASC);
                }
                $req->bindValue('debut', $debut);
                $req->bindValue('fin', $fin); 
                              
            } 
            else {
                if ($debut != null && null == $fin) {
                    switch($sorting)
                    {
                      case "periode ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_PERIODE_ASC);
                        break;
                    case "periode DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_PERIODE_DESC);
                        break;
                    case "client ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_CLIENT_ASC);
                        break;
                    case "client DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_CLIENT_DESC);
                        break;
                    case "commercial ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_COMMERCIAL_ASC);
                        break;
                    case "commercial DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_COMMERCIAL_DESC);
                        break;
                    case "ca ASC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_CA_ASC);
                        break;
                    case "ca DESC":
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_CA_DESC);
                        break;
                    default:
                        $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT_ORDER_BY_PERIODE_ASC);
                    }
                    $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT);
                    $req->bindValue('periode', $debut);
                } else if (null == $debut && null != $fin) {
                    $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_FIN);
                    $req->bindValue('periode', $fin);
                } else {
                    return $this->findAll();
                }
            }
           
            
            $req->bindValue('begin', $begin,\PDO::PARAM_INT);
            $req->bindValue('size', $end, \PDO::PARAM_INT);
            
            $req->execute();

            $resultat = array();

            while ($row = $req->fetch()) {
                $resultat[] = $this->fetchListingCA($row);
            }

            return $resultat;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/findByDebutAndFinAndLimitedAndSorted.txt", $ex->getMessage()."\n\n".$ex->getTraceAsString());
            return array();
        }
    }

    public function findByDebut($debut) {
        try {
            $req = $this->connection->prepare(ListingCAModel::$_GET_REC_BTB_CA_BY_DEBUT);

            $req->execute(array('periode' => $$debut));

            $resultat = array();

            while ($row = $req->fetch()) {
                $resultat[] = $this->fetchListingCA($row);
            }

            return $resultat;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/findAll.txt", $ex->getMessage());
            return array();
        }
    }

    public function findAll() {
        try {
            $req = $this->connection->prepare(ListingCAModel::$_GET_ALL_REC_BTB_CA);
            $req->execute();
            $resultat = array();

            while ($row = $req->fetch()) {
                $resultat[] = $this->fetchListingCA($row);
            }

            return $resultat;
        } catch (\Exception $ex) {
            Tools::writeFile("exceptions/findAll.txt", $ex->getMessage());
            return array();
        }
    }

}
