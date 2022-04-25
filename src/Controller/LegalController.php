<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès public, hors bdd : Conditions et mentions légales du site Roots
class LegalController extends AbstractController
{
    /**
     * @Route("/legal", name="app_legal")
     */
    public function index(): Response
    {
        return $this->render('legal/index.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
}
