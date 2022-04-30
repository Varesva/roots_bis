<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Cart;
// auto-wiring
use App\Repository\ProduitRepository;
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

        if ($cartService[$id] <= 1) // s'il y a deja dans le tableau cart l'id produit qui a pour quantité = 1 alors on unset (supprime)
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

        if (!empty($cartService)) 
        {
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
        $full_cart = $this->indexCart();
        // la variable qui contient le prix total du panier
        $total_cart = 0;

        if ($full_cart != "")  //si cartvar contient au moins une seule valeur (donc n'est pas vide)
        {
            // faire une boucle sur chacun des articles (quantite + produit) du panier
            foreach ($full_cart as $duo) //étant donné que la fonction total est forcéement liée au panier entier, on peut réutiliser l'appel de la fonction $this->indexCart()
            {
                $total_cart =
                    $total_cart +
                    ($duo['produit']->getPrix()
                        *
                        $duo['quantite']);
            }
        } else {
            return $full_cart;
        }

        return $total_cart;
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
