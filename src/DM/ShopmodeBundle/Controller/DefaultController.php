<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
  public function indexAction()
  {
      return $this->render('DMShopmodeBundle:Default:index.html.twig', array(
        'article.'
      ));
  }
  // ------------------------
  public function viewByIDAction($id)
  {



    return $this->render('DMShopmodeBundle:Default:viewByID.html.twig', array(
      'id' => $id
    ));
  }
  // ------------------------
  public function viewByRefAction($ref)
  {
    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:ScrapArticles')->findOneBy(array('ref' => $ref));

    if ($article === null) {
      throw new Exception("ref $ref non trouvé");
    }

    return $this->render('DMShopmodeBundle:Default:viewByRef.html.twig', array('article' => $article));
  }

  public function viewByMarqueAction($marque)
  {
    $em = $this->getDoctrine()->getManager();

    $articles = $em->getRepository('DMShopmodeBundle:ScrapArticles')->findBy(array('marque' => $marque));

    if ($articles === null) {
      throw new Exception("ref $ref non trouvé");
    }

    return $this->render('DMShopmodeBundle:Default:viewByMarque.html.twig', array('articles' => $articles));
  }
}
