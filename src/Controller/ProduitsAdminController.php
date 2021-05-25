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
    * Creates a form to create a Product entity.
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

    /**
     * @Route("/admin/produits/{id}/show", name="adminProducts_show")
     */
    public function show($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Product::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le produit');
        }
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('Administration/Products/layout/show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        
        ));
    }

    /**
     * @Route("/admin/produits/{id}/edit", name="adminProducts_edit")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Product::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le produit.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('Administration/Products/layout/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Product entity.
    * @param Product $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Product $entity)
    {
        $form = $this->createForm(ProductType::class, $entity, array(
            'action' => $this->generateUrl('adminProducts_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Editer'));

        return $form;
    }

    /**
     * @Route("/admin/produits/{id}/update", name="adminProducts_update", requirements={"_method"="post|put"})
     */
    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Product::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le produit.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('adminProducts_edit', array('id' => $id)));
        }

        return $this->render('Administration/Products/layout/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/admin/produits/{id}/delete", name="adminProducts_delete", requirements={"_method"="post|delete"})
     */
    public function delete(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(Product::class)->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver le produit.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('adminProducts'));
    }

    /**
     * Creates a form to delete a Categories entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adminProducts_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}