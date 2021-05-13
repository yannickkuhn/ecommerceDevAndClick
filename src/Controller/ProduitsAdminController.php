<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class ProduitsAdminController extends AbstractController
{
    /**
     * @Route("/admin/produits", name="adminProducts")
     */
    public function index(): Response
    {
        $entities = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('Administration/Products/layout/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/admin/prodits/create", name="adminProducts_create", requirements={"_method"="post"})
     */
    public function create(Request $request)
    {
        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('adminProducts'));
        }

        return $this->render('Administration/Products/layout/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Categories entity.
    * @param Product $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Product $entity)
    {
        $form = $this->createForm(ProductType::class, $entity, [
            'action' => $this->generateUrl('adminProducts_create'),
            'method' => 'POST',
        ]);
        $form->add('submit', SubmitType::class, array('label' => 'Créer'));
        return $form;
    }

    /**
     * @Route("/admin/produits/new", name="adminProducts_new")
     */
    public function new()
    {
        $entity = new Product();
        $form   = $this->createCreateForm($entity);

        return $this->render('Administration/Products/layout/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}