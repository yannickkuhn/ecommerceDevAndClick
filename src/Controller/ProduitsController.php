<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\Categories;
use App\Repository\ProductRepository;

class ProduitsController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="produits")
     */
    public function produits(): Response
    {
        $session = $this->session;
        $products = $this->getDoctrine()->getRepository(Product::class)->findBy(array('available' => 1));

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        
        //$produits = $this->get('knp_paginator')->paginate($findProduits,$this->get('request')->query->get('page', 1),3);
        
        return $this->render('produits/layout/produits.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/categorie/{categorie}", name="categorieProduits")
     */
    public function categorieProduits(Categories $categorie = null): Response
    {
        $session = $this->session;
        $products = $this->getDoctrine()->getRepository(Product::class)->byCategorie($categorie);

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        
        //$produits = $this->get('knp_paginator')->paginate($findProduits,$this->get('request')->query->get('page', 1),3);

        return $this->render('produits/layout/produits.html.twig', [
            'products' => $products
        ]);
    }
    
    /**
     * @Route("/produit/presentation/{product}", name="presentation")
     */
    public function presentation(Product $product = null): Response
    {
        $session = $this->session;
        
        if (!$product) throw $this->createNotFoundException('La page n\'existe pas.');
        
        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        
        return $this->render('produits/layout/presentation.html.twig', [
            'product' => $product,
            'panier' => $panier
        ]);
    }
}