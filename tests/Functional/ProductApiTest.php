<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProductApiTest extends ApiTestCase
{
    public function testCreateProductValidation(): void
    {
        $client = static::createClient();

        // Envoi d'une requête POST avec données invalides (nom vide, prix négatif)
  $response = $client->request('POST', '/api/products', [
    'headers' => ['Content-Type' => 'application/ld+json'],
    'json' => [
        'name' => '',
        'price' => -5,
        'image' => 'not-a-url'
    ]
]);

        // Vérifie que la réponse HTTP est 400 (Bad Request)
        $this->assertResponseStatusCodeSame(400);

        // Vérifie que l'erreur concerne bien les champs attendus
        $this->assertJsonContains([
            'violations' => [
                ['propertyPath' => 'name'],
                ['propertyPath' => 'price'],
                ['propertyPath' => 'image']
            ],
        ]);
    }
}
