<?php

namespace blogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use blogBundle\Entity\Commentary;
use blogBundle\Form\CommentaryType;

/**
 * Commentary controller.
 *
 * @Route("/commentary")
 */
class CommentaryController extends Controller
{

    /**
     * Lists all Commentary entities.
     *
     * @Route("/", name="commentary")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('blogBundle:Commentary')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Commentary entity.
     *
     * @Route("/", name="commentary_create")
     * @Method("POST")
     * @Template("blogBundle:Commentary:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Commentary();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('commentary_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Commentary entity.
     *
     * @param Commentary $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Commentary $entity)
    {
        $form = $this->createForm(new CommentaryType(), $entity, array(
            'action' => $this->generateUrl('commentary_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Commentary entity.
     *
     * @Route("/new", name="commentary_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Commentary();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Commentary entity.
     *
     * @Route("/{id}", name="commentary_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('blogBundle:Commentary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commentary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Commentary entity.
     *
     * @Route("/{id}/edit", name="commentary_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('blogBundle:Commentary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commentary entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Commentary entity.
    *
    * @param Commentary $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Commentary $entity)
    {
        $form = $this->createForm(new CommentaryType(), $entity, array(
            'action' => $this->generateUrl('commentary_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Commentary entity.
     *
     * @Route("/{id}", name="commentary_update")
     * @Method("PUT")
     * @Template("blogBundle:Commentary:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('blogBundle:Commentary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commentary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('commentary_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Commentary entity.
     *
     * @Route("/{id}", name="commentary_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('blogBundle:Commentary')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Commentary entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('commentary'));
    }

    /**
     * Creates a form to delete a Commentary entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentary_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
