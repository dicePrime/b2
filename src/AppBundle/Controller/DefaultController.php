<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Modele\DefaultModel;
use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\Modele\UtilisateurDAO;
use AppBundle\Entity\Utilisateur;
use AppBundle\Modele\B2BOperationLigneModel;


class DefaultController extends Controller
{
   
   
    public function logout(Request $request)
    {
        $request->getSession()->set("utilisateur", NULL);
        return $this->render('default/login.html.twig', array(
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..')));
    }
    
    
    public function loginAction(Request $request)
    {
        $normalConnection = $this->get('doctrine.dbal.default_connection');
        $ldapConnection = $this->get('doctrine.dbal.ldap_connection');
               
        $session = $request->getSession();
        $cuid = $request->get('cuid');
        $password = $request->get('password');
        
        if($cuid != null && $password != null)
        {
            $utilisateurDAO = new UtilisateurDAO($ldapConnection, $normalConnection);
            $utilisateur = $utilisateurDAO->ldapAuthentify($cuid, $password); 
            
            if($utilisateur != null)
            {
                $session->set("utilisateur", $utilisateur);
                
                return $this->redirectToRoute("homepage");
                
            }
            
            else
            {
              return $this->render('default/login.html.twig', array(
              'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..')));  
            }
        }
        else
        {
            
        }
      return $this->render('default/login.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..')));  
    }
  
    
    public function homePageAction(Request $request)
    {     
        $connection = $this->get("database_connection");
        
        $defaultModel = new DefaultModel($connection);
        
        $caByYears = $defaultModel->getCaByYear();
        
        $caByMonth = $defaultModel->getEvolutionCaByMonthForYear(date("Y"));
        $caByMonthPreviousYear = $defaultModel->getEvolutionCaByMonthForYear(intval(date("Y")) -1);
        $caByMonthPreviousPreviousYear = $defaultModel->getEvolutionCaByMonthForYear(intval(date("Y")) - 2);
 
        
        
        $caValues = array();
        $years = array();
        $caMonthValues = array();
        $caPreviousYearValues = array();
        $caPreviousPreviousYearValues = array();
        $months = array();
        
        foreach($caByYears as $annee => $ca)
        {
            $years[] = $annee;
            $caValues[] = $ca;
        }
        
        foreach($caByMonth as $month => $ca)
        {
            $months[] = $month;
            $caMonthValues[] = $ca + 0.0;
        }
        
        foreach($caByMonthPreviousYear as $ca)
        {
           $caPreviousYearValues[] = $ca + 0.0;
        }
        
        foreach($caByMonthPreviousPreviousYear as $ca)
        {
           $caPreviousPreviousYearValues[] = $ca + 0.0;
        }
        
       
        $caHistory = array(array("name"=> "Chiffre d'affaire", "data" => $caValues));
       
        $evolutionComparee = array(
            array("name"=>"Evolution mensuelle 2014", "data" => $caPreviousPreviousYearValues),
            array("name"=>"Evolution mensuelle 2015", "data" => $caPreviousYearValues),
            array("name"=>"Evolution Mensuelle ".date("Y"), 'color'=> "#e67e22", "data" => $caMonthValues));
        
        $ob = new Highchart();
        $ob->chart->renderTo("columnchart");
        $ob->title->text("Chiffre d'affaire par an");
        $ob->chart->type("column");       
        $ob->xAxis->title(array('text'  => "Année"));
        $ob->yAxis->title(array('text'  => "Chiffre d'affaire"));
        $ob->xAxis->categories($years);
        $ob->series($caHistory);
        
           
        // Croissance comparée.
        $croissanceCompareeChart = new Highchart();
        $croissanceCompareeChart->chart->renderTo("mixedchart");
        $croissanceCompareeChart->title->text("Croissance mensuelle comparée du CA");
        $croissanceCompareeChart->xAxis->title(array('text' => "Mois"));
        $croissanceCompareeChart->yAxis->title(array("text" => "Chiffre d'affaire"));
        $croissanceCompareeChart->xAxis->categories($months);
        //print_r($evolutionComparee);
        $croissanceCompareeChart->series($evolutionComparee);
        
        
        
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'ca_by_years' => $ob,
            'mixed_chart' => $croissanceCompareeChart,
         ));
    }
    
    /**
     * Cette fonction initialise les variables de session, notamment
     * les éléments dont on sait qu'ils ne changeront pas du tout.
     */
  /*  public function setSessionsElements($session)
    {
       $connection = $this->get("database_connection");
       
       
       
    }*/
    
   
}
