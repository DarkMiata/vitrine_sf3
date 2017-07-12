<?php

namespace DM\ShopmodeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestControllerTest extends WebTestCase
{
    public function testBootstrap()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bootstrap');
    }

}
