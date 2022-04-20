<?php

namespace App\Controller;

use App\Service\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    // /**
    //  * @Route("/cart" name="app_cart")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('cart/index.html.twig', []);
    // }

    // ajouter un article dans le panier --- le param converter recupere l'id dans l'url
    /**
     * @Route("/cart/add/{id}", name="app_cart_add")
     */
    public function addCart($id, Cart $cart): Response
    {
        $cart->addCart($id);
        return $this->render('cart/index.html.twig', []);
    }

    // pour vider le panier
    /**
     * @Route("/cart/clear", name="app_cart_clear")
     */
    public function clearCart(Cart $cart): Response
    {
        $cart->clearCart();
        return $this->render('cart/cleared.html.twig', []);
    }
}
