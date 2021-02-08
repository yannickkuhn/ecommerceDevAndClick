<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits")
     */
    public function produitsAction(): Response
    {
        return $this->render('produits/layout/produits.html.twig');
    }
    
    /**
     * @Route("/produit", name="presentation")
     */
    public function presentationAction(): Response
    {
        return $this->render('produits/layout/presentation.html.twig');
    }
}