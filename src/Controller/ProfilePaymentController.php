<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring

use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Service\Cart\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Service\Payment\PaymentService;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\Security\Core\Security;
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
    // CONSTRUCTEUR DE CLASSE 
    private $security;
    private $cartService;
    private $session;
    private $paymentService;

    public function __construct(PaymentService $paymentService, Security $security, CartService $cartService, SessionInterface $session)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->session = $session;
        $this->paymentService = $paymentService;
    }
    // afficher la page de paiement avec toutes les infos
    /**
     * @Route("/", name="app_profile_payment")
     */
    public function createPayment(): Response
    {
        // récupérer la valeur de la variable avec prix et devise monétaire
        $paymentIntent = $this->paymentService->paymentIntent();
        // récuperer le prix total ttc du panier
        $total_ttc = $this->cartService->calculTTC();

        // renvoyer la vue
        return $this->render('profile_payment/index.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,
            'total_ttc' => $total_ttc,
        ]);
    }

    // afficher la page de confirmation de paiement 
    /**
     * @Route("/confirmation", name="app_profile_payment_confirm", methods={"GET", "POST"})
     */
    public function confirm(): Response
    {
        // récupérer la valeur de la variable avec prix et devise monétaire
        $paymentIntent = $this->paymentService->paymentIntent();
        // récuperer le prix total ttc du panier
        $total_ttc = $this->cartService->calculTTC();
        // récupérer le panier dans sa totalité (prix, produits, quantité)
        $cartService = $this->cartService->indexCart();
        
        // créer les infos à ajouter dans ligne commande, envoyer la commande en base de données
        $this->paymentService->confirmOrderDB();
    
        // vider le panier après paiement
        $this->cartService->clear();

        // retourner la vue de confirmation
        return $this->render('profile_payment/confirm.html.twig', []);
    }
}
