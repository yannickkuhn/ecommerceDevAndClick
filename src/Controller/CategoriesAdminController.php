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
     * @Route("/admin/categories/create", name="adminCategories_create", requirements={"_method"="post"})
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
     * @Route("/admin/categories/{id}/show", name="adminCategories_show")
     */
    public function show($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Categories::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la catégorie');
        }
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('Administration/Categories/layout/show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        
        ));
    }

    /**
     * @Route("/admin/categories/{id}/edit", name="adminCategories_edit")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Categories::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la catégorie.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('Administration/Categories/layout/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Categories entity.
    * @param Categories $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Categories $entity)
    {
        $form = $this->createForm(CategoriesType::class, $entity, array(
            'action' => $this->generateUrl('adminCategories_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Editer'));

        return $form;
    }

    /**
     * @Route("/admin/categories/{id}/update", name="adminCategories_update", requirements={"_method"="post|put"})
     */
    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Categories::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la catégorie.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('adminCategories_edit', array('id' => $id)));
        }

        return $this->render('Administration/Categories/layout/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/admin/categories/{id}/delete", name="adminCategories_delete", requirements={"_method"="post|delete"})
     */
    public function delete(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(Categories::class)->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver la catégorie.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('adminCategories'));
    }

    /**
     * Creates a form to delete a Categories entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adminCategories_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}
