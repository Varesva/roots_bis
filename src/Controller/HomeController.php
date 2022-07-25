<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Controller\SearchController;
use App\Service\Display\DisplayService;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // afficher dans carousel les derniers restaurants ajoutés en bdd
    /**
     * @Route("/", name="app_home", methods={"GET", "POST"})
     */
    public function home(RestaurantRepository $restaurantRepository, Request $request): Response
    {
        // CAROUSEL
        $incr5 = 0;

        for ($i = 1; $i <= 3; $i++) {

            $homeCarousel[] = $restaurantRepository->findBy(
                [],
                ['id' => 'DESC'],
                $limit = 5,
                $offset = $incr5,
            );
            $incr5 = $incr5 + 5;
        }

        return $this->renderForm('home/index.html.twig', [
            'carousel_restaurants' => $homeCarousel,
        ]);
    }

    // ADMIN - DASHBOARD  
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     */
    public function homeAdmin(): Response
    {
        return $this->render('admin/dashboard.html.twig', []);
    }
}
