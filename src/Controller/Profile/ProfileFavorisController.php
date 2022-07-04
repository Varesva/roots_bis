<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Controller\Profile;
// auto-wiring

use App\Service\Favoris\FavorisService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès privé (user), hors bdd : Favoris du site Roots
/**
 * @Route("/profile/favoris")
 */
class ProfileFavorisController extends AbstractController
{
    // voir les favoris
    /**
     * @Route("/", name="app_profile_favoris_index", methods={"GET"})
     */
    public function indexFav(FavorisService $favorisService)
    {
        $full_fav = $favorisService->indexFav();
        return $this->render('profile_favoris/index.html.twig', [
            'ligne_favoris' => $full_fav,
        ]);
    }

    // ajouter et retirer un resto des favoris
    /**
     * @Route("/ajouter/{id}", name="app_profile_control_favoris")
     */
    public function FavAddRemove($id, FavorisService $favorisService)
    {
        // appel de la fonction controlFav (ajout et retirer un fav) de la classe FavorisService du service container 
        $favorisService->FavAddRemove($id);
        return $this->redirectToRoute('app_profile_favoris_index');
    }

    // vider les favoris
    /**
     * @Route("/vider", name="app_profile_favoris_clear")
     */
    public function clearFav(FavorisService $favorisService)
    {
        $favorisService->clearFav();
        return $this->redirectToRoute('app_profile_favoris_index');
    }    
}
