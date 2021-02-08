<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    /**
     * @Route("/page/{id}", name="page")
     */
    public function pageAction($id): Response
    {
        return $this->render('pages/layout/pages.html.twig');
    }
}
