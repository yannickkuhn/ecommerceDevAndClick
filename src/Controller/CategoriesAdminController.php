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

class CategoriesAdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function premierepage(): Response
    {
        // page à supprimer (uniquement pour les routes)
        return $this->render('Administration/index.html.twig');
    }

    /**
     * @Route("/admin/categories", name="adminCategories")
     */
    public function index(): Response
    {
        $entities = $this->getDoctrine()->getRepository(Categories::class)->findAll();

        return $this->render('Administration/Categories/layout/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/admin/categories/create", name="adminCategories_create")
     */
    public function create(Request $request)
    {
        $entity = new Categories();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('adminCategories_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('adminCategories'));
        }

        return $this->render('Administration/Categories/layout/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Categories entity.
    * @param Categories $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Categories $entity)
    {
        $form = $this->createForm(CategoriesType::class, $entity, [
            'action' => $this->generateUrl('adminCategories_create'),
            'method' => 'POST',
        ]);
        $form->add('submit', SubmitType::class, array('label' => 'Créer'));
        return $form;
    }

    /**
     * @Route("/admin/categories/new", name="adminCategories_new")
     */
    public function new()
    {
        $entity = new Categories();
        $form   = $this->createCreateForm($entity);

        return $this->render('Administration/Categories/layout/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/categories/show", name="adminCategories_show")
     */
    public function show()
    {
    }

    /**
     * @Route("/admin/categories/edit", name="adminCategories_edit")
     */
    public function edit()
    {
    }
}
