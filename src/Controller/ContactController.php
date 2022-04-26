<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Form\ContactType;
use App\Service\Email\EmailService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public, hors bdd : Page de contact user non inscrit 
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $contact_request, EmailService $emailService): Response
    {
        // création du formualire 
        $contact_form = $this->createForm(ContactType::class);
        // récupération du formulaire 
        $contact_form->handleRequest($contact_request);
        // traitement du formulaire
        if ($contact_form->isSubmitted()) {

            // récupération des données du tableau de données du formulaire si et seulement si les données sont valides
            $valid_contact_form = $contact_form->getData();
            $valid_contact_email = $contact_form->getData('valid_contact_form.email');
            
            
            // si formulaire est valide, envoyer un email de confirmation d'envoi de la prise de contact
                // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
                // $user = $this->getUser();
            $emailService->sendEmail (
                // $valid_contact_email,
                'you@example.com',
                "Prise de contact - Roots", 
                $valid_contact_form, 
                "email/contact.html.twig"
            );
            
            // si les infos du contact form sont valides, redirection vers la page de confirmation d'envoi de formulaire aux données valides

            // titre h1 - page de confirmation
            $contact_title = "Message envoyé !";
            // retourner la vue
            return $this->renderForm('contact/confirm.html.twig', [
            'valid_contact_form' => $valid_contact_form,
            'contact_title' => $contact_title
            ]);

        } else {
            // si invalide, renvoyer la même page de contact
            $controller_name = "Contacter Roots";
            $contact_h1 = "Nous contacter";
            return $this->renderForm('contact/index.html.twig', [
                'contact_form' => $contact_form,
                'controller_name' => $controller_name,
                'contact_h1' => $contact_h1,
            ]);
        }
    }
}
