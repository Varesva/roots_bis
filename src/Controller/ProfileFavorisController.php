<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Controller;
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
    // Pour voir les favoris
    /**
     * @Route("/", name="app_profile_favoris_index", methods={"GET"})
     */
    public function indexFav(FavorisService $favorisService)
    {
        // nom de la page navigateur
        $controller_name = 'Mes favoris - Roots';
        // titre H1
        $fav_h1 = 'Mes favoris';
        
        $full_fav = $favorisService->indexFav();
        return $this->render('profile_favoris/index.html.twig', [
            'controller_name' => $controller_name,
            'fav_h1' =>$fav_h1,
            'ligne_favoris' => $full_fav,
        ]);
    }

    // Pour ajouter et retirer un produit des favoris
    /**
     * @Route("/fav/{id}", name="app_profile_control_favoris")
     */
    public function controlFav($id, FavorisService $favorisService)
    {
        // appel de la fonction controlFav (ajout et retirer un fav) de la classe FavorisService du service container 
        $favorisService->controlFav($id);

        // retourner la vue 
        return $this->redirectToRoute('app_profile_favoris_index');
   
    }

    // pour vider les favoris
    /**
     * @Route("/vider", name="app_profile_favoris_clear")
     */
    public function clearFav(FavorisService $favorisService)
    {
        $favorisService->clearFav();
        return $this->redirectToRoute('app_profile_favoris_index');
    }    
}
