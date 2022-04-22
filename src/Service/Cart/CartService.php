<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Cart;
// auto-wiring
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    // constructeur de classe Cart - pour tjrs avoir ces variables avec la classe
    protected $produitRepository;
    protected $session;
    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }
    // fin constructeur de classe Cart 

    // création de panier et ajouter un article au panier--- le param converter recupere l'{id} dans l'url
    public function add(int $id)
    {
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) // si tableau cart est not empty
        {
            $cart[$id] = $cart[$id] + 1; // increment: ajouter 1 au nombre de produit de l'id correspondant
        } else {
            // ajouter dans le tableau cart l'id produit et la quantité = à 1
            $cart[$id] = 1;
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('cart', $cart);
    }

    // Pour voir le panier dans son intégralité: avec les données des produits ajoutés dedans
    public function indexCart(): array
    {
        $cart = $this->session->get('cart', []);
        // afficher le panier avec toutes ses données dans un nouveau tableau
        $viewCart = [];
        foreach ($cart as $id => $quantite) {
            $viewCart[] =
                [
                    'produit' => $this->produitRepository->find($id),
                    'quantite' => $quantite
                ];
        }
        return $viewCart;
    }

    // pour obtenir le prix total de l'intégralité des données de produit dans le panier 
    public function totalCart(): float
    {
        // la variable qui contient le prix total du panier
        $total_cart = 0;
        // faire une boucle sur chacun des articles (quantite + produit) du panier
        foreach ($this->indexCart() as $full_cart) //étant donné que la fonction total est forcéement liée au panier entier, on peut réutiliser l'appel de la fonction $this->indexCart()
        {
            $total_cart = $full_cart['quantite'] * $full_cart['produit']->getPrix();
        }
        return $total_cart;
    }

    // Supprimer un seul article du panier
    public function remove(int $id)
    {
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
        $cart = $this->session->get('cart', []);
        // fonction if pour indiquer que si le panier n'est pas empty, on retire l'id visé
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('cart', $cart);
    }

    // pour vider entièrement le panier
    public function clear()
    {
        $this->session->clear('cart');
    }
}
