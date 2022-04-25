<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès public hors bdd : A propos de Roots
class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="app_about")
     */
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'A propos de Roots',
        ]);
    }
}
