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
    public function produitsAction(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        //dd($products);
        return $this->render('produits/layout/produits.html.twig', [
            'products' => $products
        ]);
    }
    
    /**
     * @Route("/produit", name="presentation")
     */
    public function presentationAction(): Response
    {
        return $this->render('produits/layout/presentation.html.twig');
    }
}