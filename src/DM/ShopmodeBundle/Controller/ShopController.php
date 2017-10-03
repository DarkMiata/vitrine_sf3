<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use DM\ShopmodeBundle\Entity\Articles;
use DM\ShopmodeBundle\Repository\ArticlesRepository;
use DM\ShopmodeBundle\Entity\ArticlesPhotos;
use DM\ShopmodeBundle\Repository\ArticlesPhotosRepository;

class ShopController extends Controller
  {

  const ARTICLE_PAR_PAGE   = 16;
  const PAGINATION_INDEX   = 4;
  const PATH_IMG_NOT_FOUND = "site/canard-jaune.jpg";

  // ========================================
  // ========================================
  /**
   * @Route("/", name="dm_shopmode_index")
   */
  public function indexAction(Request $req) {
    $currentUrl = $this->getCurrentUrlToSession($req);

    // Par défaut, la première page est la page T-shirt (temporaire)
    if (isset($currentUrl) == null)
    {
      $currentUrl = $this->generateUrl('dm_shopmode_viewBlockList', [
      'cat'  => 'T-shirt',
      'page' => 1,
        ]);
    }

    return $this->redirect($currentUrl);
  }
  // ------------------------
  /**
   * @Route("/loginchecked", name="dm_shopmode_loginchecked")
   */
  public function loginCheckedAction(Request $req) {
    $lastUrl = $this->getCurrentUrlToSession($req);

    return $this->redirect($lastUrl);
//    return $this->render('erreurs/error.html.twig');
  }
  // ------------------------
  /**
   * @Route("/articles/{cat}/{page}", name="dm_shopmode_viewBlockList")
   */
  public function viewBlockListAction($cat, $page = 1, Request $req) {
    // Sauvegarde en session les infos de localisation page
    $this->sessionInfoPageSave($req, $cat, $page);
    $this->setCurrentUrlToSession($req);

    $countCat = $this->getDoctrine()->getRepository(Articles::class)
        ->countByCat($cat); // nombre d'articles dans la catégorie

    $maxPage   = ceil($countCat / self::ARTICLE_PAR_PAGE);
    $indexPage = ($page - 1) * self::ARTICLE_PAR_PAGE;
    $articles  = $this->getDoctrine()->getRepository(Articles::class)
        ->findByPage($indexPage, $cat);

    foreach ($articles as $article) {
      $photoFileName = $this->getDoctrine()
          ->getRepository(ArticlesPhotos::class)
          ->findPathByRef($article->getref());

      $article->setPhoto($photoFileName);
      // créé le tableau de chaque article avec l'information de photo
      $articlesArray[] = $article;
    }

    $pathUrlPagin = $this->generatePagination($page, $cat, $maxPage);

    return $this->render('article/viewblocklist.html.twig', [
          'articlesArray' => $articlesArray,
          'photoPath'     => $photoFileName,
          'pathUrl'       => $pathUrlPagin['returnForward'],
          'maxPage'       => $maxPage,
          'indexPage'     => $pathUrlPagin['index'],
          'pathUrlRoot'   => $pathUrlPagin['pathUrlRoot'],
    ]);
  }
  // ------------------------
  /**
   * @Route("/article/{customRef}", name="dm_shopmode_article")
   */
  public function viewArticleAction($customRef, Request $req) {

    $ref = $customRef; //!!! temporaire !!!

    $this->setCurrentUrlToSession($req);

    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:Articles')
        ->findOneBy(array('ref' => $ref));

    $photoFileName = $this->getDoctrine()
        ->getRepository(ArticlesPhotos::class)
        ->findByRef($ref)->getFileName();

    return $this->render('article/article.html.twig', [
          'article'       => $article,
          'photoFileName' => $photoFileName,
    ]);
  }
  // ========================================
  // ========================================
  // Sauvegarde la page actuel  en session pour le bouton retour de la vue article.
  private function sessionInfoPageSave($req, $cat, $page) {

    $returnButtonUrl = $this->generateUrl('dm_shopmode_viewBlockList', [
      'cat'  => $cat,
      'page' => $page,
    ]);

    $req->getsession()->set('cat', $cat);
    $req->getSession()->set('page', $page);

    $req->getSession()->set('returnButtonUrl', $returnButtonUrl);
  }
  // ------------------------
  private function findPathPhotoByRef($ref) {
    $photo = $this->getDoctrine()->getRepository(ArticlesPhotos::class)
        ->findByRef($ref);

    // Si la photo par la référence n'est pas trouvé, le path = ""
    if ($photo === null) {
      $photoFileName = self::PATH_IMG_NOT_FOUND;
      $this->get('logger')->error('findPathPhotoByRef - photo path ref: "'
          . $ref . '" non trouvé');
    }
    else {
      $photoFileName = $photo->getFileName();
    }

    return $photoFileName;
  }
  // ------------------------
  private function generatePagination($indexPage, $categorie, $maxPage) {
    $pathUrlRoot = $this->generateUrl('dm_shopmode_viewBlockList', [
      'cat' => $categorie,
    ]);

    if ($indexPage > $maxPage) {
      $indexPage = $maxPage;
    }

    if ($indexPage >= 2) {
      $previousPathUrl = $this->generateUrl('dm_shopmode_viewBlockList', [
        'cat'  => $categorie,
        'page' => $indexPage - 1,
      ]);
    }
    else {
      $previousPathUrl = '#';
    }

    if ($indexPage < $maxPage) {
      $nextPathUrl = $this->generateUrl('dm_shopmode_viewBlockList', [
        'cat'  => $categorie,
        'page' => $indexPage + 1,
      ]);
    }
    else {
      $nextPathUrl = '#';
    }

    $paths['returnForward'] = ['previousPathUrl' => $previousPathUrl,
      'nextPathUrl'     => $nextPathUrl,
    ];

    for ($i = $indexPage - self::PAGINATION_INDEX; $i <= ($indexPage + self::PAGINATION_INDEX); $i++) {
      if (($i < 1) or ( $i == $indexPage) or ( $i > $maxPage)) {
        continue;
      }

      $paths['index'][] = $i;
    }

    //$paths['index']       = [5, 6, 8, 9]; // A supprimer
    $paths['pathUrlRoot'] = $pathUrlRoot;

    return $paths;
  }
  // ------------------------
  private function setCurrentUrlToSession($request) {
    $currentUrl = $request->getUri();
    $request->getSession()->set('currentUrl', $currentUrl);
  }
  // ------------------------
  private function getCurrentUrlToSession($request) {
    $currentUrl = $request->getsession()->get('currentUrl');

    $this->get('logger')->error('currentUrl: '.$currentUrl);

//    if ($currentUrl == null) { $currentUrl = $this->generateUrl('dm_shopmode_panier'); }
    if ($currentUrl == null) { $currentUrl = '#'; }

    return $currentUrl;
  }
  // ------------------------


  // ------------------------
  // end class
  }
