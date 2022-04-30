<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Display;
// auto-wiring
use App\Repository\ProduitRepository;
use App\Repository\RestaurantRepository;

class DisplayService
{
    // constructeur de classe Display : affichage des restaurants et produits  - pour tjrs avoir ces variables avec la classe
    protected $restaurantRepository;
    protected $produitRepository;

    public function __construct(RestaurantRepository $restaurantRepository, ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;
        $this->restaurantRepository = $restaurantRepository;
    }
    // fin constructeur de classe Display : affichage des restaurants et produits 

    // Pour voir le panier dans son intégralité: avec les données des produits ajoutés dedans
    public function showResto(int $id)
    {
        
        if ($id ) 
        {
            // foreach ($displayService as $id => $quantite) {
            //     $full_cart[] = [
            //         'produit' => $this->produitRepository->find($id),
            //         'quantite' => $quantite
            //     ];
            // }
            // return $full_cart;
        }
        // puis enregistrer l'ajout effectué du produit 
        // $this->session->set('cartService', $cartService);
    }
}