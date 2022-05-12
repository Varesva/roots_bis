<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Payment;

// auto-wiring
use App\Service\Cart\CartService;
use Symfony\Component\Security\Core\Security;

class PaymentService
{
    // constructeur de classe PaymentService - pour tjrs avoir ces variables avec la classe
    protected $cartService;
    protected $user;

    public function __construct(CartService $cartService, Security $security)
    {
        $this->cartService = $cartService;
        $this->security = $security;
    }
    // fin constructeur de classe PaymentService

    public function index()
    {
        // $total_cart_ht = $this->cartService->totalCart();

        // prix total TTC provenant du panier CartService - Cart ctrl
        $total_ttc = $this->cartService->calculTTC();
        
        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51KquMELfBciygh7TYzw8WnFFP1EpsrvalTo583O4BscGUCU1CsR7DU9IEzhDm3AjZBFhGK0KnelB4LVOEMVwTRjd00hHXC1Xji');

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total_ttc * 100,
            'currency' => 'eur',
            'payment_method_types' => [
                'bancontact',
                'card',
                'giropay',
                'sepa_debit',
                'sofort',
            ],
        ]);
        // vérification de la clé secrète
        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];
        // retourner la valeur de $paymentIntent; au ctrl
        return $paymentIntent;
    }

    // envoie en base de données 
    // public function OrderInDB() {
    //     // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
    //     $cartService = $this->cartService->get('cartService', []);

    //     $user = $this->security->getUser(); 

    // }
}
