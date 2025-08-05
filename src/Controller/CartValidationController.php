<?php

namespace App\Controller;

use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class CartValidationController extends AbstractController
{
    #[Route('/cart/validation', name: 'app_cart_validation')]
    public function index(): Response
    {
        return $this->render('cart_validation/index.html.twig', [
            'controller_name' => 'CartValidationController',
        ]);
    }

    #[Route('/api/carts/{id}/validate', name: 'cart_validate', methods: ['POST'])]
    public function validateCart(int $id, EntityManagerInterface $em): JsonResponse
    {
        $cart = $em->getRepository(Cart::class)->find($id);

        if (!$cart) {
            throw new NotFoundHttpException('Cart not found');
        }

        if ($cart->getStatus() === 'validated') {
            return new JsonResponse(['error' => 'Cart already validated'], 400);
        }

        $cart->setStatus('validated');
        $cart->setValidatedAt(new \DateTime());

        $em->flush();

        return new JsonResponse([
            'message' => 'Cart validated successfully',
            'cart_id' => $cart->getId(),
            'validated_at' => $cart->getValidatedAt()->format('Y-m-d H:i:s')
        ]);
    }
}
