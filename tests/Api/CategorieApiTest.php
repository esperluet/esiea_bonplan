<?php

namespace App\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategorieApiTest extends WebTestCase
{
    protected $client;
    protected $jwtToken;

    public function setUp(): void
    {
        $this->client = static::createClient();

        if(!$this->jwtToken) {
            $this->jwtToken = $this->getJwtToken();
        }
    }

    public function getJwtToken(): string
    {
        $this->client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'admin@esiea.fr',
                'password' => 'aqwzsx_edcrfv12345'
            ])
        );

        $response = $this->client->getResponse();
        $this->assertResponseIsSuccessful(); // Vérifie que la requête s'est bien passée

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('token', $data); // Vérifie que la clé existe

        return $data['token'];
    }
    public function testListCategorie()
    {
        $this->client->request("GET","/api/categories", [], [], [
            'Authorization' => 'Bearer '. $this->jwtToken
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }
}