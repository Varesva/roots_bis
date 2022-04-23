<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilePaymentController extends AbstractController
{
    /**
     * @Route("/profile/payment", name="app_profile_payment")
     */
    public function index(): Response
    {
        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51KquMELfBciygh7TYzw8WnFFP1EpsrvalTo583O4BscGUCU1CsR7DU9IEzhDm3AjZBFhGK0KnelB4LVOEMVwTRjd00hHXC1Xji');

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            // 'amount' => totalCart($cartService->produit),
            // 'amount' => calculateOrderAmount($jsonObj->items),
            'amount' => 500,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];
        
        return $this->render('profile_payment/index.html.twig', [
          'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    /**
     * @Route("/profile/payement/confirm", name="app_profile_payment_confirm")
     */
    public function confirm(): Response
    {
        return $this->render('profile_payment/confirm.html.twig', [
        ]);
    }

}
