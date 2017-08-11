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

class ShopController extends Controller
  {

  const ARTICLE_PAR_PAGE = 16;
  const PAGINATION_INDEX =  4;
  const PATH_IMG_NOT_FOUND = "site/canard-jaune.jpg";

  // ========================================
  // ========================================
  /**
   * @Route("/", name="dm_shopmode_index")
   */
  public function indexAction() {
    return $this->render('article/index.html.twig', [
      ]);
  }
  // ------------------------
  /**
   * @Route("/articles/{cat}/{page}", name="dm_shopmode_viewBlockList")
   */
  public function viewBlockListAction($cat, $page = 1, Request $req) {
    // Sauvegarde en session les infos de localisation page
    $this->sessionInfoPageSave($req, $cat, $page);

    $countCat  = $this->getDoctrine()->getRepository(Articles::class)
        ->countByCat($cat); // nombre d'articles dans la catégorie

    $maxPage    = ceil($countCat / self::ARTICLE_PAR_PAGE);
    $indexPage  = ($page - 1) * self::ARTICLE_PAR_PAGE;
    $articles   = $this->getDoctrine()->getRepository(Articles::class)
        ->findByPage($indexPage, $cat);

    foreach ($articles as $article) {
      $photoFileName = $this->findPathPhotoByRef($article->getref());

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
  public function viewArticleAction($customRef) {

    $ref = $customRef; //!!! temporaire !!!

    $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('DMShopmodeBundle:Articles')
        ->findOneBy(array('ref' => $ref));

    $photoFileName = $this->findPhotoByRef($ref)->getFileName();

    return $this->render('article/article.html.twig', [
          'article'       => $article,
          'photoFileName' => $photoFileName,
    ]);
  }
  // ------------------------
  /**
   * @Route("/panier", name="dm_shopmode_panier")
   */
  public function ListePanierAction(Request $req) {
    $panier = $req->getSession()->get('panier');

    return $this->render('article/panier.html.twig', [
      'panier' => $panier,
    ]);
  }
  // ------------------------
  /**
   * @Route("/panierPost", name="dm_shopmode_panierPost")
   */
  public function panierPostAction(Request $req) {
    $ref      = $req->get('ref');
    $taille   = $req->get('taille');
    $quantité = $req->get('quantité');
    $prix     = $req->get('prix');
    $name     = $req->get('name');
    $marque   = $req->get('marque');

    // récupère le panier en session et ajoute le nouvel article
    $panier = $req->getSession()->get('panier');

    // génération token id commande article
    $token = uniqid();

    $panier[] = [
      'ref'       => $ref,
      'taille'    => $taille,
      'quantité'  => $quantité,
      'prix'      => $prix,
      'name'      => $name,
      'marque'    => $marque,
      'token'     => $token,
    ];

    $req->getSession()->set('panier', $panier);

    return $this->redirectToRoute('dm_shopmode_panier');
  }
  // ------------------------
  /**
   * @Route("/supprimeArticlePanierPost/{token}", name="dm_shopmode_supprimeArticlePanierPost")
   */
  public function supprimeArticlePanierAction($token, Request $req) {
    $panier = $req->getSession()->get('panier');

    $count = count($panier);

    for ($i = 0; $i < $count; $i++) {
      if ($panier[$i]['token'] == $token) {
        unset($panier[$i]);
      }
    }

    $req->getSession()->set('panier', $panier);

    return $this->redirectToRoute('dm_shopmode_panier');
  }
  // ========================================
  // ========================================

  // Sauvegarde la page actuel  en session pour le bouton retour de la vue article.
  private function sessionInfoPageSave($req, $cat, $page) {

    // Désactivé en attendant correction bug
    // Bug: mauvaise route après une connection utilisateur.

    $returnButtonUrl = $this->generateUrl('dm_shopmode_viewBlockList', [
      'cat'  => $cat,
      'page' => $page,
    ]);

//    // !!!! Temporaire -
//    $returnButtonUrl = $this->generateUrl('dm_shopmode_index');
//    // !!!

    $req->getsession()->set('cat', $cat);
    $req->getSession()->set('page', $page);

    $req->getSession()->set('returnButtonUrl', $returnButtonUrl);
  }
  // ------------------------
  private function findPhotoByRef($ref) {
    $em = $this->getDoctrine()->getManager();

    $photo = $em->getRepository('DMShopmodeBundle:ArticlesPhotos')
        ->findOneBy(array('refArticle' => $ref));

    //var_dump($photo);

    if ($photo === NULL) {
      //throw new Exception("photo by ref, ref $ref non trouvé");

      $photo = NULL;
    }

    return $photo;
  }
  // ------------------------
  private function findPathPhotoByRef($ref) {
    $photo = $this->findPhotoByRef($ref);

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

    if ($indexPage > $maxPage) { $indexPage = $maxPage; }

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

    $paths['returnForward'] = [ 'previousPathUrl' => $previousPathUrl,
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
  // end class
  }

