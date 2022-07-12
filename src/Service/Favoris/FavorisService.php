<?php
namespace App\Service\Favoris;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Repository\ProduitRepository;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavorisService
{
    protected $session;
    protected $restaurantRepository;
    protected $security;
    protected $userRepo;

    public function __construct(SessionInterface $session, RestaurantRepository $restaurantRepository, Security $security, UserRepository $userRepo)
    {
        $this->session = $session;

        $this->restaurantRepository = $restaurantRepository;
        $this->security = $security;
        $this->userRepo = $userRepo;
    }

    // Pour voir les favoris dans son intégralité: avec les données des produits ajoutés dedans
    public function indexFav()
    {
        // pour crééer le favoris si la session (tableau) est inexistante ou l'actualiser si déjà créée
        $favorites = $this->session->get('favoris', []);

        if (!empty($favorites)) {
            foreach ($favorites as $id) {
                $full_fav [] = [
                    'restaurant'=> $this->restaurantRepository->find($id),
                ];
            }
            return $full_fav;
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('favoris', $favorites);
    }

    // ajouter un article au favoris--- le param converter recupere l'{id} dans l'url
    public function FavAddRemove(int $id)
    {
        $favorites = $this->session->get('favoris', []);
        if (!empty($favorites[$id])) // si tableau de favoris est not empty
        {
            // decrement: retirer 1 au produit correspondant à l'id
            unset($favorites[$id]);
        } else
        {
            // increment: ajouter 1 au produit correspondant à l'id
            $favorites[$id] = $id;
        } 
        // puis enregistrer l'ajout effectué du produit dans les favoris
        $this->session->set('favoris', $favorites);
    }

    // public function FavAddAndRemove(Restaurant $restoId, User $userId) {

    //     if($restoId != null and $userId != null) {

    //         $restaurant = new Restaurant();
    //         // $restaurant->getNom();
    //         $restaurant->addFavori($userId);
    //         // $this->restaurantRepository->add($restaurant);

    //         $user = new User();
    //         $user->addFavori($restoId);
    //         // $this->userRepo->add($user);

            
    //     } 
    //     // else {

    //     // }

    // }

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