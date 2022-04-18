<?php
// Page d'accueil Roots

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        $home_page_name = "Accueil";
        return $this->render('home/index.html.twig', [
            'home_page_name' => $home_page_name,
        ]);
    }
}
