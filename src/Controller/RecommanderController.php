<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Form\RecommanderType;
use App\Service\Email\EmailService;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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
    public function index(Request $recommander_request, EmailService $emailService): Response
    {
        // création du formualire 
        $recommander_form = $this->createForm(RecommanderType::class);
        // récupération du formulaire 
        $recommander_form->handleRequest($recommander_request);
        // traitement du formulaire
        if ($recommander_form->isSubmitted()) {

            // récupération des données du formulaire si et seulement si les données sont valides
            $valid_recommander_form = $recommander_form->getData();
            // données du formulaire récupérées et envoyées dans la var $valid_email et comment pour l'envoi d'email
            $valid_email = $recommander_form->getData('valid_recommander_form.email');
            $valid_comment = $recommander_form->getData('valid_recommander_form.commentaire');

            // si formulaire est valide, redirection vers la page de confirmation d'envoi de formulaire aux données valides et envoyer un email de confirmation d'envoi de la recommandation
            
            // envoie de l'email 
            $emailService->sendEmail(
                $recipient= $valid_email['email'],
                'Roots - Recommandation prise en compte',
                $data=$valid_comment['commentaire'],
                'recommander/confirm_email.html.twig'
            );
            // title d'onglet navigateur - page de confirmation
            $controller_name = "Recommandation envoyée - Roots ";
            // titre h1 - page de confirmation
            $recommander_h1 = 'Recommandation envoyée !';
            // retourner la vue
            return $this->renderForm('recommander/confirm.html.twig', [
                'valid_recommander_form' => $valid_recommander_form,
                'controller_name' => $controller_name,
                'recommander_h1' => $recommander_h1
            ]);
            
        } 
        else 
        {
            // si invalide, renvoyer la même page de contact
            // titre h1 - page de confirmation
            $recommander_h1 = 'Recommander un restaurant';
            // title d'onglet navigateur - page de confirmation
            $controller_name = "Recommander un restaurant - Roots";
            return $this->renderForm('recommander/index.html.twig', [
                'recommander_form' => $recommander_form,
                'controller_name' => $controller_name,
                'recommander_h1' => $recommander_h1
            ]);
        }
    }
}
