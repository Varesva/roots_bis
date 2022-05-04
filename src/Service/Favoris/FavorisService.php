<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Favoris;
// auto-wiring
use App\Repository\ProduitRepository;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavorisService
{
    // constructeur de classe Favoris - pour tjrs avoir ces variables avec la classe
    protected $session;
    // protected $produitRepository;
    protected $restaurantRepository;

    public function __construct(SessionInterface $session, ProduitRepository $produitRepository, RestaurantRepository $restaurantRepository)
    {
        $this->session = $session;
        // $this->produitRepository = $produitRepository;
        $this->restaurantRepository = $restaurantRepository;
    }
    // fin constructeur de classe Favoris

    // Pour voir les favoris dans son intégralité: avec les données des produits ajoutés dedans
    public function indexFav()
    {
        // pour crééer le favoris si la session (tableau) est inexistante ou l'actualiser si déjà créée
        $favorisService = $this->session->get('favoris', []);

        if (!empty($favorisService)) {
            foreach ($favorisService as $id) {
                $full_fav [] = [
                    'restaurant'=> $this->restaurantRepository->find($id),
                ];
            }
            return $full_fav;
        }
        // var_dump($favorisService) ;
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('favoris', $favorisService);
    }

    // ajouter un article au favoris--- le param converter recupere l'{id} dans l'url
    public function FavAddRemove(int $id)
    {
        // pour crééer le favoris si la session est inexistante ou l'actualiser si la session est déjà créée
        $favorisService = $this->session->get('favoris', []);
        if (!empty($favorisService[$id])) // si tableau de favoris est not empty
        {
            // decrement: retirer 1 au produit correspondant à l'id
            unset($favorisService[$id]);
        } else
        {
            // increment: ajouter 1 au produit correspondant à l'id
            $favorisService[$id] = $id;
        } 
        // puis enregistrer l'ajout effectué du produit dans les favoris
        $this->session->set('favoris', $favorisService);
    }

    // retirer un article des favoris--- le param converter recupere l'{id} dans l'url
    // public function removeFav(int $id)
    // {
    //     // pour crééer le favoris si la session est inexistante ou l'actualiser si déjà créée
    //     $favorisService = $this->session->get('favoris', []);

    //     if (!empty($favorisService[$id])) // si le tableau de favoris est not empty
    //     {
    //         // on supprime du tableau la clé correspondante
    //         unset($favorisService[$id]);
    //         //    echo "Voulez-vous supprimer ce produit de vos favoris ?"; 
    //     }
    //     // puis enregistrer l'ajout effectué du produit 
    //     $this->session->set('favoris', $favorisService);
    // }

    // pour vider entièrement les favoris
    public function clearFav()
    {
        $this->session->clear('favoris');
    }
}