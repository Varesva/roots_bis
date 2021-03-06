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
     * @Route("/mentions-legales", name="app_legal")
     */
    public function mentions(): Response
    {
        return $this->render('legal/mentions.html.twig', []);
    }

    /**
     * @Route("/conditions-generales-de-vente", name="app_cgv")
     */
    public function cgv(): Response
    {
        return $this->render('legal/cgv.html.twig', []);
    }
  
    /**
     * @Route("/conditions-generales-d-utilisation", name="app_cgu")
     */
    public function cgu(): Response
    {
        return $this->render('legal/cgu.html.twig', []);
    }

    /**
     * @Route("/confidentialite-et-cookies", name="app_cookies")
     */
    public function cookies(): Response
    {
        return $this->render('legal/cookies.html.twig', []);
    }

}
