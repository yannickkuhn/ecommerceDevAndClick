<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categories;
use App\Form\CategoriesType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class CategoriesController extends AbstractController
{
    public function menu()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Categories::class)->findAll();
        
        return $this->render('Default/categories/modulesUsed/menu.html.twig', array('categories' => $categories));
    }
}