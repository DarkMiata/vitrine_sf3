<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
  {
  const ARTICLE_PAR_PAGE = 8;

  // ========================================
  // ========================================

  /**
   * @Route("/", name="dm_shopmode_homepage")
   */
  public function indexAction() {
    return $this->render('article/index.html.twig', [
          'article.'
    ]);
  }
  // ------------------------
  /**
   * @Route("/viewbyid/{id}", name="dm_shopmode_viewById")
   */
  public function viewByIDAction($id) {
    return $this->render('article/viewByID.html.twig', ['id' => $id]);
  }
  // ------------------------
  /**
   * @Route("/viewblockbyid/{id}", name="dm_shopmode_viewBlockByID")
   */
  public function viewBlockByIDAction($id) {

    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findOneBy(['id' => $id]);

    if ($article === NULL) {
      throw new Exception("view block by id, id $id non trouvé");
    }

    $photo = new \DM\ShopmodeBundle\Entity\BlzPhotos;

    $photo = $this->findPhotoByRef($article->getref());

    return $this->render('article/block_article.html.twig', [
          'article' => $article,
          'photo'   => $photo
    ]);
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

    return $this->render('article/viewByRef.html.twig', [
          'article' => $article]);
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
      throw new Exception("marque $marque non trouvé");
    }

    return $this->render('article/viewByMarque.html.twig', [
          'articles' => $articles]);
  }
  // ------------------------
  /**
   * @Route("/viewblocklist/{cat}/{page}", name="dm_shopmode_viewBlockList")
   */
  public function viewBlockListAction($cat, $page) {

    // !!! définir erreur si $page <= 0 ou > ??

    $indexPage = ($page-1)*self::ARTICLE_PAR_PAGE;

    $em = $this->getDoctrine()->getManager();

    $articles = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findby(
            ['catName' => $cat],
            ['id' => 'asc'],
            self::ARTICLE_PAR_PAGE,
            $indexPage
            );

    //var_dump($articles);

    foreach ($articles as $article) {
      // récupère le chemin de la première photo de chaque article

      $photo   = $this->findPhotoByRef($article->getref());

      // Si la photo par la référence n'est pas trouvé, le path = ""
      if ($photo === null) {
      $photoFileName = "";
      }
      else {
      $photoFileName = $photo->getFileName();
      }

      $article->setPhoto($photoFileName);
      // créé le tableau de chaque article avec l'information de phot
      $articlesArray[] = $article;
    }

    return $this->render('article/list_block.html.twig', [
          'articlesArray' => $articlesArray]);
  }
  // ========================================
  // ========================================
  /**
   *
   */
  private function findPhotoByRef($ref) {
    $em = $this->getDoctrine()->getManager();

    $photo = $em->getRepository('DMShopmodeBundle:BlzPhotos')
        ->findOneBy(array('refArticle' => $ref));

    //var_dump($photo);

    if ($photo === NULL) {
      //throw new Exception("photo by ref, ref $ref non trouvé");
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

    return $this->render('article/list_block.html.twig', [
          'articlesArray' => $articlesArray]);
  }
  // ========================================
  }
