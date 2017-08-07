<?php

namespace DM\ShopmodeBundle\Controller;

use DM\ShopmodeBundle\Entity\CatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cattype controller.
 *
 * @Route("cattype")
 */
class CatTypeController extends Controller
{
    /**
     * Lists all catType entities.
     *
     * @Route("/", name="cattype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $catTypes = $em->getRepository('DMShopmodeBundle:CatType')->findAll();

        return $this->render('cattype/index.html.twig', array(
            'catTypes' => $catTypes,
        ));
    }

    /**
     * Creates a new catType entity.
     *
     * @Route("/new", name="cattype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $catType = new Cattype();
        $form = $this->createForm('DM\ShopmodeBundle\Form\CatTypeType', $catType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($catType);
            $em->flush();

            return $this->redirectToRoute('cattype_show', array('id' => $catType->getId()));
        }

        return $this->render('cattype/new.html.twig', array(
            'catType' => $catType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a catType entity.
     *
     * @Route("/{id}", name="cattype_show")
     * @Method("GET")
     */
    public function showAction(CatType $catType)
    {
        $deleteForm = $this->createDeleteForm($catType);

        return $this->render('cattype/show.html.twig', array(
            'catType' => $catType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing catType entity.
     *
     * @Route("/{id}/edit", name="cattype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CatType $catType)
    {
        $deleteForm = $this->createDeleteForm($catType);
        $editForm = $this->createForm('DM\ShopmodeBundle\Form\CatTypeType', $catType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cattype_edit', array('id' => $catType->getId()));
        }

        return $this->render('cattype/edit.html.twig', array(
            'catType' => $catType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    // ------------------------
    /**
     * Deletes a catType entity.
     *
     * @Route("/{id}", name="cattype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CatType $catType)
    {
        $form = $this->createDeleteForm($catType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($catType);
            $em->flush();
        }

        return $this->redirectToRoute('cattype_index');
    }

    // ------------------------

    /**
     * Creates a form to delete a catType entity.
     *
     * @param CatType $catType The catType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CatType $catType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cattype_delete', array('id' => $catType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
  // ========================================

  // ========================================
}
