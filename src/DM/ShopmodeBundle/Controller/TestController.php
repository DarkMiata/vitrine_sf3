<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function bootstrapAction()
    {
        return $this->render('DMShopmodeBundle:Test:bootstrap.html.twig', array(
            // ...
        ));
    }

}
