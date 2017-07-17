<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
  {
  /**
  * @Route("/", name="dm_shopmode_homepage")
  */
  public function indexAction() {
    return $this->render('DMShopmodeBundle:Default:index.html.twig', array(
          'article.'
    ));
  }
  // ------------------------
  /**
   * @Route("/viewbyid/{id}", name="dm_shopmode_viewById")
   */
  public function viewByIDAction($id) {
    return $this->render('DMShopmodeBundle:Default:viewByID.html.twig', array(
          'id' => $id
    ));
  }
  // ------------------------
  /**
   * @Route("/viewblockbyid/{id}", name="dm_shopmode_viewBlockByID")
   */
  public function viewBlockByIDAction($id) {

    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findOneBy(array('id' => $id));

    if ($article === NULL) {
      throw new Exception("view block by id, id $id non trouvé");
    }

    $photo = new \DM\ShopmodeBundle\Entity\BlzPhotos;

    $photo = $this->findPhotoByRef($article->getref());

    return $this->render('DMShopmodeBundle:Default:block_article.html.twig', array(
          'article' => $article,
          'photo'   => $photo
    ));
  }
  // ------------------------
  /**
   * @Route("/viewbyref/{ref}", name="dm_shopmode_viewByRef")
   */
  public function viewByRefAction($ref) {
    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findOneBy(array('ref' => $ref));

    if ($article === null) {
      throw new Exception("ref $ref non trouvé");
    }

    return $this->render('DMShopmodeBundle:Default:viewByRef.html.twig', array('article' => $article));
  }
  // ------------------------
  /**
   * @Route("/viewbymarque/{marque}", name="dm_shopmode_viewByMarque")
   */
  public function viewByMarqueAction($marque) {
    $em = $this->getDoctrine()->getManager();

    $articles = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findBy(array('marque' => $marque));

    if ($articles === null) {
      throw new Exception("ref $ref non trouvé");
    }

    return $this->render('DMShopmodeBundle:Default:viewByMarque.html.twig', array('articles' => $articles));
  }
  // ------------------------
  /**
   * @Route("/viewblocklist", name="dm_shopmode_viewBlockList")
   */
  public function viewBlockListAction() {
    // création d'un tableau temporaire en manuel

    $listIdArray = array(4, 5, 6, 7, 8, 9, 10);


    foreach ($listIdArray as $id) {
      $article       = $this->findArticleById($id);
      $photoFileName = $this->findPhotoByRef($article->getref())->getFileName();

      $article->setPhoto($photoFileName);

      $articlesArray[] = $article;
    }

    return $this->render('DMShopmodeBundle:Default:list_block.html.twig', array(
          'articlesArray' => $articlesArray
    ));
  }
  // ========================================
  // ========================================

  private function findPhotoByRef($ref) {
    $em = $this->getDoctrine()->getManager();

    $photo = $em->getRepository('DMShopmodeBundle:BlzPhotos')
        ->findOneBy(array('refArticle' => $ref));

    //var_dump($photo);

    if ($photo === NULL) {
      throw new Exception("photo by ref, ref $ref non trouvé");
    }

    return $photo;
  }
  // ------------------------
  private function findArticleById($id) {

    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findOneBy(array('id' => $id));

    if ($article === NULL) {
      throw new Exception("findArticleById, id $id non trouvé");
    }

    return $article;
  }
  // ------------------------
  public function viewBlockList($listIdArray) {
    foreach ($listIdArray as $id) {
      $articlesArray[] = $this->findArticleById($id);
    }

    //var_dump($articleArray);

    return $this->render('DMShopmodeBundle:Default:list_block.html.twig', array('articlesArray' => $articlesArray));
  }
  // ========================================
  }
