<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring

use App\Service\Display\DisplayService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public, hors bdd : Page d'accueil du site Roots
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {       
        $controller_name = "Accueil - Roots";
        return $this->render('home/index.html.twig', [
            'controller_name' => $controller_name,
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurant_show", methods={"GET"})
     */
    public function showResto($id, DisplayService $displayService)
    {
        $restaurant= $displayService->showResto($id);
    
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }


    // page d'accueil du Dashboard Admin 
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('home/admin_dashboard.html.twig', [
            // 'controller_name' => 'AdminDashboardController',
        ]);
    }
     
}
