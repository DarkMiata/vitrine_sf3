<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DM\ShopmodeBundle\Entity\Articles;

class DefaultController extends Controller
{

  /**
   * @Route("/", name="homepage")
   */
  public function indexAction(Request $request)
  {
    return $this->redirectToRoute('dm_shopmode_index');
  }
  // ------------------------
    /**
   * @Route("/test", name="test")
   */
  public function testAction()
  {
    $article = $this->getDoctrine()->getRepository(Articles::class)->findOneById(4);

    var_dump($article);

    return $this->render('divers/test.html.twig', array(
    ));
  }


  // ========================================
  // ========================================

}
