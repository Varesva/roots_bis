<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Cart;
// auto-wiring
use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    // constructeur de classe Cart - pour tjrs avoir ces variables avec la classe
    protected $session;
    protected $produitRepository;

    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }
    // fin constructeur de classe Cart 

    // ajouter un article au panier--- le param converter recupere l'{id} dans l'url
    public function plusOne(int $id)
    {
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
        $cartService = $this->session->get('cartService', []);

        if (!empty($cartService[$id])) // si tableau cart est not empty
        {
            $cartService[$id] = $cartService[$id] + 1; // increment: ajouter 1 au nombre de produit de l'id correspondant
        } else {
            // ajouter dans le tableau cart l'id produit et la quantité = à 1
            $cartService[$id] = 1;
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('cartService', $cartService);
    }

    // retirer un article du panier--- le param converter recupere l'{id} dans l'url
    public function minusOne(int $id)
    {
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
        $cartService = $this->session->get('cartService', []);

        if ($cartService[$id] <= 1) // s'il y a deja dans le tableau cart l'id produit qui a pour quantité inférieur ou = 1 alors on unset (supprime)
        {
            unset($cartService[$id]);
        } else {
            $cartService[$id] = $cartService[$id] - 1; // retirer 1 au nombre de produit de l'id correspondant
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('cartService', $cartService);
    }

    // Pour voir le panier dans son intégralité: avec les données des produits ajoutés dedans
    public function indexCart()
    {
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
        $cartService = $this->session->get('cartService', []);
        // condition pour afficher le contenu du panier s'il n'est pas vide
        if (!empty($cartService)) {
            foreach ($cartService as $id => $quantite) {
                $full_cart[] = [
                    'produit' => $this->produitRepository->find($id),
                    'quantite' => $quantite
                ];
            }
            return $full_cart;
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('cartService', $cartService);
    }

    // pour obtenir le prix total de l'intégralité des données de produit dans le panier 
    public function totalCart()
    {
        // récupérer la variable d'affichage du panier complet (prix,produits et quantités)
        $full_cart = $this->indexCart();
        // la variable qui contient le prix HT total du panier
        $total_cart_ht = 0;

        //si le panier n'est pas vide/contient au moins une seule valeur
        if (!empty($full_cart)) {
            //étant donné que la fonction total est forcéement liée au panier entier, on peut réutiliser l'appel de la fonction $this->indexCart() en tant que (as) la nouvelle variable $duo
            foreach ($full_cart as $duo)
            // faire une boucle (foreach) sur chacun des articles (quantite + produit) du panier
            {
                // calcul du prix HT
                $total_cart_ht =
                    $total_cart_ht +
                    ($duo['produit']->getPrix()
                        *
                        $duo['quantite']);
                
                // calcul du prix TTC
            }
        } else {
            // si le panier est vide, retourner la valeur initiale vers le ctrl
            return $full_cart;
        }
        // retourner les valeurs des variables calculés dans la condition foreach
        return $total_cart_ht;
    }
    
    public function calculTTC() {
        // récupérer le total ht
        $total_cart_ht = $this->totalCart();
        // prix total avec TVA
        $total_ttc = 0;
        // si le prix ht est différent de 0 (€)
        if ($total_cart_ht != "0") {
            
            // calcul de la TVA ==> prix ht + 20% (20/100) de prix ht = montant ttc  -- et la fonction php round pour arrondir le prix donné
            $total_ttc = round(($total_cart_ht + ($total_cart_ht*20/100)), 2);
        }
        // retourner le prix TTC
        return $total_ttc;
    }

    // Supprimer un seul article du panier
    public function delete(int $id)
    {
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
        $cartService = $this->session->get('cartService', []);
        // fonction if pour indiquer que si le panier n'est pas empty, on retire l'id visé
        if (!empty($cartService[$id])) {
            unset($cartService[$id]);
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('cartService', $cartService);
    }

    // pour vider entièrement le panier
    public function clear()
    {
        $this->session->clear('cartService');
    }
}
