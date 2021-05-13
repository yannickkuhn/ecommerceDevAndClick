<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{

    public function menu()
    {
        //$em = $this->getDoctrine()->getManager();
        //$pages = $em->getRepository('PagesBundle:Pages')->findAll();
        $pages = [];
        
        return $this->render('Default/pages/modulesUsed/menu.html.twig', array('pages' => $pages));
    }
}
