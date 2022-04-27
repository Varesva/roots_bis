<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring

use App\Service\Favoris\FavorisService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès privé (user), hors bdd : Favoris du site Roots
class ProfileFavorisController extends AbstractController
{
    // Pour voir les favoris
    /**
     * @Route("/profil/favoris", name="app_profile_favoris")
     */
    // public function indexFav(FavorisService $favoris): Response
    // {
        
    //     return $this->render('profile_favoris/index.html.twig', [
    //         'controller_name' => 'Mes favoris - Roots',
    //     ]);
    // }
}
