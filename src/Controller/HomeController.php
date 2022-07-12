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

        return $this->render('home/index.html.twig', [
            'carousel_restaurants' => $homeCarousel,
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
