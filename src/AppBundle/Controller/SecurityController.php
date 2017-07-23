<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
  {
  /**
   * @Route("/admin", name="admin")
   */
  public function adminAction() {
    return $this->render('Security/admin.html.twig', array(
            // ...
    ));
  }
  // ------------------------
  /**
   * @Route("/login", name="login")
   */
  public function loginAction(Request $request, AuthenticationUtils $authUtils) {
    // get the login error if there is one
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();

    return $this->render('Security/login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
    ));
  }
  // ------------------------
  /**
   * @Route("/logout", name="logout")
   */
  public function logoutAction() {
    return $this->render('Security/logout.html.twig', array(
            // ...
    ));
  }
  }
