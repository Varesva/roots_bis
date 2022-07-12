<?php

namespace App\Controller;

use App\Service\Display\DisplayService;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // afficher dans carousel les derniers restaurants ajoutés en bdd
    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function home(RestaurantRepository $restaurantRepository): Response
    {
        $homeCarousel1 = $restaurantRepository->findBy(
            [],
            ['id' => 'DESC'],
            $limit = 5,
        );

        $homeCarousel2 = $restaurantRepository->findBy(
            [],
            ['id' => 'DESC'],
            $limit = 5,
            $offset = 5,          
        );

        $homeCarousel3 = $restaurantRepository->findBy(
            [],
            ['id' => 'DESC'],
            $limit = 5,
            $offset = 10,          
        );
        return $this->render('home/index.html.twig', [
            'carousel_restaurants1' => $homeCarousel1,
            'carousel_restaurants2' => $homeCarousel2,
            'carousel_restaurants3' => $homeCarousel3,
        ]);
    }

    public function searchBar()
    {

        return $this->renderForm('home/search.html.twig', []);
    }

    // ADMIN - DASHBOARD  
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     */
    public function homeAdmin(): Response
    {
        return $this->render('home/admin/dashboard.html.twig', []);
    }
}
