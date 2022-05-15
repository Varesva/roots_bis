<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Payment;

// auto-wiring
use Stripe\Stripe;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use Stripe\PaymentIntent;
use App\Service\Cart\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentService
{
    // constructeur de classe PaymentService - autowiring - pour tjrs avoir ces variables avec la classe
    //récuperer la panier
    private $cartService;
    //récupérer le user
    private $security;
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
    // fin constructeur de classe PaymentService

    public function paymentIntent()
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

    // envoi en base de données 
    public function confirmOrderDB()
    {
        // définir la variable  -  (pour créer le panier si la session est inexistante ou l'actualiser si déjà créée)
        $cartService = $this->session->get('cart', []);

        // -------------------- PARTIE COMMANDE

        // définir et instancier la classe Commande (dans adminCommandeCtrl)
        $confirmCommande = new Commande(); 

        // definir et recup l'objet user connecté à la session en recuperant le user dans la classe component de Symfony : Security
        $logged_User = $this->security->getUser();
        //  enregistrer la modif (ajout du user connecté) dans l'objet commande et recuperer le user pour l'objet de Commande à créer
        $confirmCommande->setUser($logged_User);

        // définir la date de la commande avec la classe PHP DateTime
        $order_date = new DateTime('now');
        $order_date->format('COOKIE');
        // recup et insérer la date actualisée dans l'objet
        $confirmCommande->setDate($order_date);

        // recup le prix total TTC du panier
        $total_facturation = $this->cartService->calculTTC();
        // recup et insérer le prix total dans l'objet
        $confirmCommande->setTotalFacturation($total_facturation);

        // executer la modif : ajouter les modifications au repository 
        $this->commandeRepository->add($confirmCommande);

        // -------------  PARTIE LIGNE COMMANDE
        
        // définir la variable
        $add_ligneCommande = new LigneCommande();

        // faire une boucle pour chaque produit du panier
        foreach ($cartService as $id => $quantite) {

            // instancier la classe LigneCommande (entité)
            $add_ligneCommande = new LigneCommande();

            // définir la variable qui contient les valeurs de l'objet/l'id recupérer par la fonction find dans ProduitRepo
            $produit_add_ligneCommande = $this->produitRepository->find($id);

            // récuperer et insérer l'id de la création d'objet
            $add_ligneCommande->setProduit($produit_add_ligneCommande);

            // recup et insérer la quantité
            $add_ligneCommande->setQuantite($quantite);

            // recup et insere prix du produit multiplié par la quantité du produit dans le panier
            $add_ligneCommande->setPrix($produit_add_ligneCommande->getPrix() * $quantite);

            // recup et ajouter à la commande
            $add_ligneCommande->setCommande($confirmCommande);

            // ajouter les modifications au repository 
            $this->ligneCommandeRepository->add($add_ligneCommande);
        }




        // recup et insérer les lignes commandes concernées dans l'objet
        // $confirmCommande->addLignesCommande($add_ligneCommande);




    }
}
