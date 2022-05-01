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
use Stripe\Service\BillingPortal\SessionService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/profile/paiement")
 */
class ProfilePaymentController extends AbstractController
{
    /**
     * @Route("/", name="app_profile_payment")
     */
    public function index(PaymentService $paymentService, CartService $cartService): Response
    {
        // récupérer la valeur de la variable avec prix et devise monétaire
        $paymentIntent = $paymentService->index();
        $total_ttc = $cartService->calculTTC();

        // renvoyer la vue
        return $this->render('profile_payment/index.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,
            'total_ttc' => $total_ttc,
        ]);
    }


    /**
     * @Route("/confirmation", name="app_profile_payment_confirm")
     */
    public function confirm(CartService $cartService,SessionInterface $session): Response
    {
        $cartService = $cartService->indexCart();
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée

        $cartService = $session->get('cartService', []);

        // $paymentIntent = $this->paymentService->index();

        // $cartService = $cartService->clear();

        // vider le panier après paiement
        // $cartService->clear();
        // retourner la vue de confirmation
        return $this->render('profile_payment/confirm.html.twig', []);
    }
}
