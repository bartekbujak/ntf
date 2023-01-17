<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Application\Enum\Resources;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SchemaFunctionalTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        parent::setUp();
    }

    /**
     * @dataProvider getSchemaProvider
     */
    public function testGetSchema(string $resource, string $type): void
    {
        $this->client->request(method:'GET', uri:'/api/admin/schema/'.$resource, parameters:['type' => $type]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function getSchemaProvider(): array
    {
        return [
//            [Resources::NEWS->value, 'create'],
//            [Resources::NEWS->value, 'edit'],
        ];
    }
}
