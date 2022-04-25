<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Form\RecommanderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public, hors bdd : Page de recommandation de restaurants du site Roots
class RecommanderController extends AbstractController
{
    /**
     * @Route("/recommander", name="app_recommander")
     */
    public function index(Request $recommander_request): Response
    {
        // création du formualire 
        $recommander_form = $this->createForm(RecommanderType::class);
        // récupération du formulaire 
        $recommander_form->handleRequest($recommander_request);
        // traitement du formulaire
        if ($recommander_form->isSubmitted()) {
            // récupération des données du formulaire si et seulement si les données sont valides
            $valid_recommander_form = $recommander_form->getData();
            // si valide, redirection vers la page de confirmation d'envoi de formulaire aux données valides
            $recommander_form_submitted_title = "Recommandation envoyée !";
            return $this->renderForm('recommander/confirm.html.twig', [
                'valid_recommander_form' => $valid_recommander_form,
                'recommander_form_submitted_title' => $recommander_form_submitted_title
            ]);
        } else {
            // si invalide, renvoyer la même page de contact
            $recommander_form_request_title = "Recommander un restaurant";
            return $this->renderForm('recommander/index.html.twig', [
                'recommander_form' => $recommander_form,
                'recommander_form_request_title' => $recommander_form_request_title
            ]);
        }
    }
}
