<?php

declare(strict_types=1);

namespace App\Tests\Functional\UI;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocFunctionalTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        parent::setUp();
    }

    public function testGetApiDocSuccess()
    {
        $this->client->request(method:'GET', uri:'/api/doc');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
