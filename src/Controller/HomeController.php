<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public, hors bdd : Page d'accueil du site Roots
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
