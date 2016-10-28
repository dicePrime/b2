<?php


/**
 * Cette classe regroupe les méthodes utilisées pour avoir les données 
 * qui doivent être affichées sur la page d'accueil notamment:
 * 
 * 1- Les courbes d'évolution du CA et des activations, des désactivations et du netAdd par mois de l'année en cours
 * 2- Les courbes d'évolution du CA par, des activations, des désactivations et du netAdd par année
 */

namespace AppBundle\Modele;

/**
 * Description of DefaultModel
 *
 * @author BMHB8456
 */

use AppBundle\Commons\Tools;

class DefaultModel {
    
    
    public static $_GET_CA_BY_MONTH_FOR_A_YEAR = "SELECT * FROM vw_ca_global WHERE periode like :periode ";
    
    public static $_GET_ALL_CA_BY_MONTH = "SELECT * FROM vw_ca_global";
    
    
    private $connection;  
    
    public function __construct($connection) {
        
        $this->connection = $connection;
    }
        
    
    //put your code here
    /**
     * Cette fonction prend en paramètre une année et retourne un tableau
     * associatif avec pour chaque mois la valeur du ca
     * @param type $year
     */
    public function getEvolutionCaByMonthForYear($year)
    {
       $req = $this->connection->prepare(DefaultModel::$_GET_CA_BY_MONTH_FOR_A_YEAR);
       
       $resultat = array();
       
       $req->execute(array("periode" => "%".$year."%"));
       
      foreach(Tools::$_MONTHS_BY_INDEX as $index=>$month)
       {
           $resultat[$month] = 0;
       }
       
      
       
       while($row = $req->fetch())
       {
          $periode = $row['PERIODE'];
          $key = substr($periode, 4);
          $resultat[Tools::$_MONTHS_BY_INDEX[$key]] = $row['CA1'];
       }
       
             
       return $resultat; 
    }
    
    /**
     * Cette fonction prend en paramètre une année et retourne le chiffre d'affaire
     * pour cette année
     * @param type $year
     */
    public function getCaByYear()
    {
       $req = $this->connection->prepare(DefaultModel::$_GET_ALL_CA_BY_MONTH);       
       $resultat = array();       
       $req->execute();       
       while($row = $req->fetch())
       {
          $periode = $row['PERIODE'];
          $key = substr($periode, 0, 4);
                
          if(isset($resultat[$key]))
          {
              $resultat[$key] = $resultat[$key] + $row['CA1'];
          }
          
          else
          {
              $resultat[$key] = $row['CA1'];
          }
       }       
       return $resultat;
       
    }
    
    /**
     * cette fonction prend en paramètre une année et retourne un tableau
     * contenant l'évolution du parc au cours de cette année
     * @param type $year
     */
    public function getEvolutionParcForYear($year)
    {
        
    }
    
    
}
