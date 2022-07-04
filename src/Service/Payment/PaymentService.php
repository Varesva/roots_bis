<?php
namespace App\Service\Payment;

use DateTime;
use DateTimeZone;
use Stripe\Stripe;
use App\Entity\User;
use App\Entity\Commande;
use Stripe\PaymentIntent;
use App\Entity\LigneCommande;
use App\Form\UserAddressFormType;
use App\Service\Cart\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentService
{
    private $cartService;
    private $security;  //récupérer le user
    private $commandeRepository;
    private $ligneCommandeRepository;
    private $session;
    private $produitRepository;

    public function __construct(CartService $cartService, Security $security, LigneCommandeRepository $ligneCommandeRepository, CommandeRepository $commandeRepository, SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->cartService = $cartService;
        $this->security = $security;
        $this->commandeRepository = $commandeRepository;
        $this->ligneCommandeRepository = $ligneCommandeRepository;
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }

    public function paymentIntent()
    {
        // $total_cart_ht = $this->cartService->totalCart();
        $total_ttc = $this->cartService->calculTTC();

        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51KquMELfBciygh7TYzw8WnFFP1EpsrvalTo583O4BscGUCU1CsR7DU9IEzhDm3AjZBFhGK0KnelB4LVOEMVwTRjd00hHXC1Xji');

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total_ttc * 100,
            'currency' => 'eur',
            'automatic_payment_methods[enabled]' => true,
        ]);

        // vérification de la clé secrète
        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        return $paymentIntent;
    }

    // GENERER UN NUM DE REFERENCE COMMANDE ALEATOIRE
    function generateRandStr($length = 6)
    {
        $char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($char);

        $randomStr = '';

        for ($i = 0; $i < $length; $i++) {

            $randomStr .= $char[rand(0, $charLength - 1)];       
        }

        return $randomStr;

    }

    // ENVOI EN BASE DE DONNEES
    public function confirmOrderDB()
    {
        $cartService = $this->session->get('cart', []);


        // -------------------- PARTIE COMMANDE(facture) --------------------

        // INSTANCIATION DE CLASSE
        $confirmCommande = new Commande();

        $loggedUser = $this->security->getUser();
        $confirmCommande->setUser($loggedUser);

        // définir la date de la commande avec la classe PHP DateTime
        $orderDate = new DateTime('now');
        $orderDate->format('COOKIE');
        $orderDate->setTimeZone(new DateTimeZone('Europe/Paris'));
        $confirmCommande->setDate($orderDate);
        
        // RECUP TOTAL TTC PANIER
        $total_facturation = $this->cartService->calculTTC();
        $confirmCommande->setTotalFacturation($total_facturation);

        // générer n° de commande réf random
        $orderRefNumber = $this->generateRandStr();
        $confirmCommande->getReference($orderRefNumber);
        $confirmCommande->setReference($orderRefNumber);

        $this->commandeRepository->add($confirmCommande);


        // --------------------  PARTIE LIGNE COMMANDE --------------
        
        // INSTANCIATION DE CLASSE
        $add_ligneCommande = new LigneCommande();

        // faire une boucle pour chaque produit du panier
        foreach ($cartService as $id => $quantite) {

            $produit_add_ligneCommande = $this->produitRepository->find($id); // récupérer l'id du produit
            $add_ligneCommande->setProduit($produit_add_ligneCommande);
            $add_ligneCommande->setQuantite($quantite);
            $add_ligneCommande->setPrix($produit_add_ligneCommande->getPrix() * $quantite);
            $add_ligneCommande->setCommande($confirmCommande);

            $this->ligneCommandeRepository->add($add_ligneCommande);
        }
        return $orderRefNumber;
    }
}
