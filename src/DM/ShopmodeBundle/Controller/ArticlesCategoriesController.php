<?php

namespace DM\ShopmodeBundle\Controller;

use DM\ShopmodeBundle\Entity\ArticlesCategories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Articlescategory controller.
 *
 * @Route("articlescategories")
 */
class ArticlesCategoriesController extends Controller
{
    /**
     * Lists all articlesCategory entities.
     *
     * @Route("/", name="articlescategories_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articlesCategories = $em->getRepository('DMShopmodeBundle:ArticlesCategories')->findAll();

        return $this->render('articlescategories/index.html.twig', array(
            'articlesCategories' => $articlesCategories,
        ));
    }

    /**
     * Creates a new articlesCategory entity.
     *
     * @Route("/new", name="articlescategories_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $articlesCategory = new Articlescategory();
        $form = $this->createForm('DM\ShopmodeBundle\Form\ArticlesCategoriesType', $articlesCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($articlesCategory);
            $em->flush();

            return $this->redirectToRoute('articlescategories_show', array('id' => $articlesCategory->getId()));
        }

        return $this->render('articlescategories/new.html.twig', array(
            'articlesCategory' => $articlesCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a articlesCategory entity.
     *
     * @Route("/{id}", name="articlescategories_show")
     * @Method("GET")
     */
    public function showAction(ArticlesCategories $articlesCategory)
    {
        $deleteForm = $this->createDeleteForm($articlesCategory);

        return $this->render('articlescategories/show.html.twig', array(
            'articlesCategory' => $articlesCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing articlesCategory entity.
     *
     * @Route("/{id}/edit", name="articlescategories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ArticlesCategories $articlesCategory)
    {
        $deleteForm = $this->createDeleteForm($articlesCategory);
        $editForm = $this->createForm('DM\ShopmodeBundle\Form\ArticlesCategoriesType', $articlesCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articlescategories_edit', array('id' => $articlesCategory->getId()));
        }

        return $this->render('articlescategories/edit.html.twig', array(
            'articlesCategory' => $articlesCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a articlesCategory entity.
     *
     * @Route("/{id}", name="articlescategories_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ArticlesCategories $articlesCategory)
    {
        $form = $this->createDeleteForm($articlesCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($articlesCategory);
            $em->flush();
        }

        return $this->redirectToRoute('articlescategories_index');
    }

    /**
     * Creates a form to delete a articlesCategory entity.
     *
     * @param ArticlesCategories $articlesCategory The articlesCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ArticlesCategories $articlesCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('articlescategories_delete', array('id' => $articlesCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
