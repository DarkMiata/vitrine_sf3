<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

use DM\ShopmodeBundle\Entity\Articles;

class PanierController extends Controller
{
    // ------------------------
  /**
   * @Route("/panierPost", name="dm_shopmode_panierPost")
   */
  public function panierPostAction(Request $req) {
    $ref      = $req->get('ref');
    $taille   = $req->get('taille');
    $quantité = $req->get('quantité');

    // récupère le panier en session et ajoute le nouvel article
    $panier = $req->getSession()->get('panier');

    // génération token id commande article
    $token = uniqid();

    $panier[] = [
      'ref'       => $ref,
      'taille'    => $taille,
      'quantité'  => $quantité,
      'token'     => $token,
    ];

    $session = $req->getSession();
    $session->set('panier', $panier);

    if ($session->has('nbrArticles')) {
      $nbrArticles = $session->get('nbrArticles');
      $nbrArticles++;
      $session->set('nbrArticles', $nbrArticles);
    }
    else { $session->set('nbrArticles', 1); }

    $returnUrl = $req->getSession()->get('returnButtonUrl');

    if ($returnUrl == null) { $returnUrl = $this->generateUrl('dm_shopmode_index'); }

    // retourne à la page courante de la liste articles
    return $this->redirect($returnUrl);
  }
  // ------------------------
  /**
   * @Route("/supprimeArticlePanierPost/{token}", name="dm_shopmode_supprimeArticlePanierPost")
   */
  public function supprimeArticlePanierAction($token, Request $req) {
    $panier = $req->getSession()->get('panier');

    $count = count($panier);

    foreach ($panier as $key => $article) {
      if ($article['token'] == $token) {
        unset($panier[$key]);
        break;
      }
    }

    $req->getSession()->set('panier', $panier);

    return $this->redirectToRoute('dm_shopmode_panier');
  }
  // ------------------------
  /**
   * @Route("/panier", name="dm_shopmode_panier")
   */
  public function listePanierAction(Request $req) {
    $panier = $req->getSession()->get('panier');

    if ($panier == null) {
      return $this->render('article/panier.html.twig', [
            'panier' => $panier,
      ]);
    }

    // temporaire !!
    foreach ($panier as $key => $contenuPanier) {
      $article = new Articles();
      $article = $this->getDoctrine()->getRepository(Articles::class)
          ->findOneByRef($panier[$key]['ref']);

      $panier[$key]['prix']   = $article->getPrix();
      $panier[$key]['name']   = $article->getName();
      $panier[$key]['marque'] = $article->getMarque();
    }

    return $this->render('article/panier.html.twig', [
          'panier' => $panier,
    ]);
  }
// ------------------------

// ========================================
  private function countArticles() {
    $session = $req->getSession();
    $session->set('panier', $panier);

    if ($session->has('nbrArticles')) {
      $nbrArticles = $session->get('nbrArticles');
      $nbrArticles++;
      $session->set('nbrArticles', $nbrArticles);
    }
    else { $session->set('nbrArticles', 1); }
  }

// ========================================
}
