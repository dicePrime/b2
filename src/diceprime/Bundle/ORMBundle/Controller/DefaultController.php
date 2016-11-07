<?php

namespace diceprime\Bundle\ORMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('diceprimeORMBundle:Default:index.html.twig', array('name' => $name));
    }
}
