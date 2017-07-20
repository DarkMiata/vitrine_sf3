<?php

namespace DM\DBMaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MaintenanceController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('DMDBMaintenanceBundle:Default:index.html.twig');
    }
}
