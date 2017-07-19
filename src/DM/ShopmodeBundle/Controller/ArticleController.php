<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use DM\ShopmodeBundle\Entity\ScrapArticles;

class ArticleController extends Controller
  {

  const ARTICLE_PAR_PAGE   = 8;
  const PATH_IMG_NOT_FOUND = "site/canard-jaune.jpg";

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
    $error = "";

    $article = new ScrapArticles();
    $article = $this->findArticleById($id);

    if ($article === null) {
    $error = "Id $id non trouvé"; }

    return $this->render('article/viewByID.html.twig', [
      'error'   => $error,
      'article' => $article,
        ]);
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

    $countCat   = $this->countCat($cat);
    $maxPage    = ceil($countCat / self::ARTICLE_PAR_PAGE);
    $indexPage  = ($page - 1) * self::ARTICLE_PAR_PAGE;

    $articles = $this->findArticlesByPage($indexPage, $cat);


    foreach ($articles as $article) {
      $refArticle = $article->getref();
      $photoFileName = $this->findPathPhotoByRef($refArticle);

      $article->setPhoto($photoFileName);
      // créé le tableau de chaque article avec l'information de phot
      $articlesArray[] = $article;
    }

    return $this->render('article/list_block.html.twig', [
          'articlesArray' => $articlesArray,
          'photoPath'     => $photoFileName,
        ]);
  }
  // ------------------------
  /**
   * @Route("/count_cat/{cat}", name="dm_shopmode_countCat")
   */
  public function countCatAction($cat) {
    $count = $this->countCat($cat);

    return $this->render('article/count_cat.html.twig', [
          'cat'   => $cat,
          'count' => $count,
    ]);
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

      $photo = NULL;
    }

    return $photo;
  }
  // ------------------------
  private function findArticleById($id) {
    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findOneBy(array('id' => $id));

//    if ($article === NULL) {
//      throw new Exception("findArticleById, id $id non trouvé");
//    }

    return $article;
  }
  // ------------------------
  private function countCat(string $cat) {
    $em = $this->getDoctrine()->getManager();

    $repository = $em->getRepository('DMShopmodeBundle:ScrapArticles');

    $count = $repository
        ->createQueryBuilder('a')
        ->select('COUNT(a)')
        ->where('a.catName = :cat')
        ->setparameter('cat', $cat)
        ->getQuery()
        ->getSingleScalarResult();

    return $count;
  }
  // ------------------------
  private function getArticleFromDB($categorie, $indexPage) {
    $em = $this->getDoctrine()->getManager();

    $articles = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findby(
        ['catName' => $categorie],
            ['id' => 'asc'],
            self::ARTICLE_PAR_PAGE,
            $indexPage
    );

    return $articles;
  }
  // ------------------------
  private function findArticlesByPage($indexPage, $catName) {
    $em = $this->getDoctrine()->getManager();

    $articles = $em->getRepository('DMShopmodeBundle:ScrapArticles')
        ->findby(
        ['catName' => $catName],
            ['id' => 'asc'],
            self::ARTICLE_PAR_PAGE,
            $indexPage
    );

    return $articles;
  }
  // ------------------------
  private function findPathPhotoByRef($ref) {
    $photo = $this->findPhotoByRef($ref);

    // Si la photo par la référence n'est pas trouvé, le path = ""
    if ($photo === null) {
      $photoFileName = self::PATH_IMG_NOT_FOUND;
    }
    else {
      $photoFileName = $photo->getFileName();
    }

    return $photoFileName;
  }
  // ------------------------
  // end class
  }

