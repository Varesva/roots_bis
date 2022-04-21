<?php

namespace App\Controller;

use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    // Pour voir le panier
    /**
     * @Route("/cart", name="app_cart_index")
     */
    public function index(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $cart = $session->get('cart', []);
        $viewCart = [];
        foreach($cart as $id => $quantite)
        {
            // afficher le panier avec toutes ses données
            $viewCart[]=
            [
                'produit'=> $produitRepository->find($id),
                'quantite'=> $quantite
            ];
        }
        return $this->render('cart/index.html.twig', [
            'ligne_commande' => $viewCart
        ]);
    }

    // création de panier et ajouter un article au panier--- le param converter recupere l'{id} dans l'url
    /**
     * @Route("/cart/add/{id}", name="app_cart_add")
     */
    public function add($id, SessionInterface $session): Response
    {
        // pour crééer le panier si la session est inexistante ou l'actualiser si déjà créée
        $cart = $session->get('cart', []);
        if(!empty($cart[$id])) // si tableau cart est not empty
        {
            $cart[$id]= $cart[$id] + 1; // increment: ajouter 1 au nombre de produit de l'id correspondant
        } 
        else
        {
            // ajouter dans le tableau cart l'id produit et la quantité = à 1
            $cart[$id] = 1;
        }
        // puis enregistrer l'ajout effectué du produit 
        $session->set('cart', $cart);

        dd($session->get('cart'));

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
