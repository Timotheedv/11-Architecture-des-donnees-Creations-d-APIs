<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Lasagnes aux épinards',
                'description' => 'Lasagnes fraîches aux épinards et ricotta',
                'price' => 8.99,
                'image' => 'https://via.placeholder.com/300x200?text=Lasagnes',
                'available' => true
            ],
            [
                'name' => 'Pizza margherita',
                'description' => 'Pizza traditionnelle avec sauce tomate et mozzarella',
                'price' => 7.50,
                'image' => 'https://via.placeholder.com/300x200?text=Pizza+margherita',
                'available' => true
            ],
            [
                'name' => 'Quiche lorraine',
                'description' => 'Quiche aux lardons et crème fraîche',
                'price' => 6.20,
                'image' => 'https://via.placeholder.com/300x200?text=Quiche+lorraine',
                'available' => true
            ],
            [
                'name' => 'Salade César',
                'description' => 'Salade verte avec poulet, parmesan et croûtons',
                'price' => 5.90,
                'image' => 'https://via.placeholder.com/300x200?text=Salade+César',
                'available' => true
            ],
            [
                'name' => 'Tarte aux pommes',
                'description' => 'Tarte sucrée traditionnelle aux pommes',
                'price' => 4.50,
                'image' => 'https://via.placeholder.com/300x200?text=Tarte+aux+pommes',
                'available' => true
            ],
            // Ajoutez ici d'autres produits pour arriver jusqu'à 10-15
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setImage($data['image']);
            $product->setAvailable($data['available']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
