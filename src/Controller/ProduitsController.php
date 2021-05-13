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
    public function produits(SessionInterface $session): Response
    {
        $session = $this->session;
        $em = $this->getDoctrine()->getManager();
        $findProduits = $em->getRepository(ProductRepository::class)->findBy(array('disponible' => 1));

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