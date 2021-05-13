<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function panierAction()
    {
        return $this->render('panier/layout/panier.html.twig');
    }
    
    /**
     * @Route("/panier/livraison", name="livraison")
     */
    public function livraisonAction()
    {
        return $this->render('panier/layout/livraison.html.twig');
    }
    
    /**
     * @Route("/panier/validation", name="validation")
     */
    public function validationAction()
    {
        return $this->render('panier/layout/validation.html.twig');
    }
}
