<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;

class CartValidationTest extends ApiTestCase
{
    public function testValidateCart(): void
    {
        $client = static::createClient();

        // Récupérer EntityManager pour créer un panier en base
        $em = $client->getContainer()->get('doctrine')->getManager();

        $cart = new Cart();
        $cart->setStatus('pending');
        $em->persist($cart);
        $em->flush();

        // Effectuer la requête POST avec le header Content-Type correct
        $response = $client->request('POST', '/api/carts/' . $cart->getId() . '/validate', [
            'headers' => ['Content-Type' => 'application/ld+json']
        ]);
        
        // Assertion que la réponse est un succès
        $this->assertResponseIsSuccessful();

        // Vérifier le contenu JSON attendu (si applicable)
        $this->assertJsonContains([
            'message' => 'Cart validated successfully',
            'cart_id' => $cart->getId()
        ]);

        // Recharger le panier de la base
        $em->refresh($cart);

        // Vérifier que le statut et la date de validation ont bien été mis à jour
        $this->assertSame('validated', $cart->getStatus());
        $this->assertNotNull($cart->getValidatedAt());
    }
}
