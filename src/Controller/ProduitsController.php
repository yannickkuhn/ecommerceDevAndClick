<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits")
     */
    public function produits(): Response
    {
        $products = [];
        return $this->render('produits/layout/produits.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/categorie/{categorie}", name="categorieProduits")
     */
    public function categorieProduits(Categories $categorie = null): Response
    {
        $products = [];
        return $this->render('produits/layout/produits.html.twig', [
            'products' => $products
        ]);
    }
    
    /**
     * @Route("/produit/presentation", name="presentation")
     */
    public function presentation(): Response
    {
        return $this->render('produits/layout/presentation.html.twig');
    }
}