<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring

use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Service\Cart\CartService;
use App\Service\Payment\PaymentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilePaymentController extends AbstractController
{
    /**
     * @Route("/profile/paiement", name="app_profile_payment")
     */
    public function index(PaymentService $paymentService): Response
    {
        $paymentIntent = $paymentService->index();    

    
        // renvoyer la vue
        return $this->render('profile_payment/index.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,
            // 'total_payment' => $total_cart_ht,

        ]);
       
    }




    /**
     * @Route("/profile/payement/confirm", name="app_profile_payment_confirm")
     */
    public function confirm(CartService $cartService): Response
    {
        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51KquMELfBciygh7TYzw8WnFFP1EpsrvalTo583O4BscGUCU1CsR7DU9IEzhDm3AjZBFhGK0KnelB4LVOEMVwTRjd00hHXC1Xji');

        $total_cart_ht = $cartService->totalCart();

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 500,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        return $this->render('profile_payment/confirm.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,

            'total_payment' => $total_cart_ht,

        ]);
    }
}
