<?php
namespace App\Controller\Profile;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use App\Service\Favoris\FavorisService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

// Controller d'accès privé (user), hors bdd : Favoris du site Roots
/**
 * @Route("/profile/favoris")
 */
class ProfileFavorisController extends AbstractController
{
    protected $favorisService;
    protected $restaurantRepository;
    protected $security;

    public function __construct(FavorisService $favorisService, RestaurantRepository $restaurantRepository, Security $security)
    {
        $this->favorisService = $favorisService;
        $this->restaurantRepository = $restaurantRepository;
        $this->security = $security;
    }

    // voir les favoris
    /**
     * @Route("/", name="app_profile_favoris_index", methods={"GET"})
     */
    public function indexFav()
    {
        $full_fav = $this->favorisService->indexFav();
        // $u = $this->security->getUser();
        // $full_fav = $this->restaurantRepository->findByFav($u);

        // dd($full_fav);
        // $full_fav = $restaurant->getFavoris();

        return $this->render('profile_favoris/index.html.twig', [
            'ligne_favoris' => $full_fav,
        ]);
    }

    // ajouter et retirer un resto des favoris
    /**
     * @Route("/ajouter/{id}", name="app_profile_control_favoris", methods={"GET"})
     */
    public function FavAddRemove($id, Restaurant $restaurant)
    {
        // $user = $this->security->getUser();
        // $userId = $user->getId();
        // $restoId = $restaurant;

        // $this->favorisService->FavAddAndRemove($restoId, $user);

        // $this->addFlash('success', 'Ajouté aux favoris');

        $this->favorisService->FavAddRemove($id);
        
        return $this->redirectToRoute('app_profile_favoris_index');    
    }

    // public function FavAddRemove($id)
    // {
    //     // appel de la fonction controlFav (ajout et retirer un fav) de la classe FavorisService du service container 
    //     $this->favorisService->FavAddRemove($id);
    //     return $this->redirectToRoute('app_profile_favoris_index');
    // }



    // vider les favoris
    /**
     * @Route("/vider", name="app_profile_favoris_clear")
     */
    public function clearFav()
    {
        $this->favorisService->clearFav();
        return $this->redirectToRoute('app_profile_favoris_index');
    }    
}
