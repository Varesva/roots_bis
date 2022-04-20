<?php 

namespace App\Service;

use App\Repository\GiftcardRepository;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart {
    // constructeur de classe Cart - pour tjrs avoir ces variables avec la classe
    protected $livreRepository;
    protected $giftcardRepository;
    protected $session;

    public function __construct(SessionInterface $session, LivreRepository $livreRepository, GiftcardRepository $giftcardRepository)
    {
        $this->session=$session;
        $this->livreRepository=$livreRepository;
        $this->giftcardRepository=$giftcardRepository;
    }
    // fin constructeur de classe Cart 

    // méthode de classe Cart pour ajouter un article aux favoris
    public function addCart(int $id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id] = $cart[$id] + 1;
        } else {
            // ajouter dans le tableau crée cart l'identifiant produit et la quantité
            $cart[$id] = 1;
        }

        // enregistrer l'ajout du produit 
        $this->session->set('cart', $cart);
    }

    // vider entièrement le panier
    public function clearCart()
    {
        $this->session->remove('cart');
    }
}