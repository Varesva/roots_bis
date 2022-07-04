<?php
namespace App\Controller;

use App\Service\Display\DisplayService;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public, hors bdd : Page d'accueil du site Roots
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function home(RestaurantRepository $restaurantRepository): Response
    {
        // afficher dans carousel les derniers restaurants ajoutés en bdd
        $carousel_restaurants = $restaurantRepository->findBy(
            [],
            ['id' => 'DESC'],
            $limit = 4,
            $offset = null,
            4,
            8,
        );
        return $this->render('home/index.html.twig', [
            'carousel_restaurants' => $carousel_restaurants,
        ]);
    }

    public function searchBar() {

        return $this->renderForm('home/search.html.twig', [
        ]);
    }

    // page d'accueil du Dashboard Admin 
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     */
    public function homeAdmin(): Response
    {
        return $this->render('home/admin/index.html.twig', []);
    }



}
