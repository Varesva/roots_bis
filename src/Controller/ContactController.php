<?php
// Page de contact user non inscrit - hors base de données  

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $contact_request): Response
    {
        // création du formualire 
        $contact_form = $this->createForm(ContactType::class);
        // récupération du formulaire 
        $contact_form->handleRequest($contact_request);
        // traitement du formulaire
        if ($contact_form->isSubmitted()) {
            // récupération des données du formulaire si et seulement si les données sont valides
            $valid_contact_form = $contact_form->getData();
            // si valide, redirection vers la page de confirmation d'envoi de formulaire aux données valides
            $contact_form_submitted_title = "Message envoyé !";
            return $this->renderForm('contact/confirm.html.twig', [
                'valid_contact_form' => $valid_contact_form,
                'contact_form_submitted_title' => $contact_form_submitted_title
            ]);
        } else {
            // si invalide, renvoyer la même page de contact
            $contact_form_request_title = "Contacter Roots";
            return $this->renderForm('contact/index.html.twig', [
                'contact_form' => $contact_form,
                'contact_form_request_title' => $contact_form_request_title
            ]);
        }
    }
}
