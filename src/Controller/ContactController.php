<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\Email\EmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contactez-nous", name="app_contact")
     */
    public function contact(Request $request, EmailService $emailService): Response
    {
        $contactForm = $this->createForm(ContactType::class);

        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            // USER
            $ok_contactForm = $contactForm->getData();

            $ok_email = $ok_contactForm['email'];

            $noReplySubject = 'Accusé de réception de votre message';

            $emailTemplate = 'email/contact_email.html.twig';

            // ADMIN
            $adminEmailTemplate = 'email/contact_by_email_to_admin.html.twig';

            $subjectContact = 'Nouveau ticket utilisateur : Prise de contact';

            // ENVOI EMAIL ADMIN : NOUVEAU TICKET UTILISATEUR
            $emailService->sendAdminEmail(
                $sender = $ok_email,
                $subjectContact,
                $data = $ok_contactForm,
                $adminEmailTemplate,
            );

            // ENVOI MAIL AUTO CONTACT - ACCUSE DE RECEPTION
            $emailService->sendNoReply(
                $recipient = $ok_email,
                $noReplySubject,
                $ok_contactForm,
                $emailTemplate
            );

            $this->addFlash('success', 'Message envoyé !');

            return $this->renderForm(
                'contact/confirm.html.twig',
                [
                    $sender,
                    $recipient,
                    'data' => $data,
                ]
            );

            // header("Location : home/index.html.twig");

        } else {
            return $this->renderForm('contact/index.html.twig', [
                'contactForm' => $contactForm,
                // 'commandeRef' => 'aRemplir',
            ]);
        }
    }

    // afficher la page A propos
    /**
     * @Route("/a-propos", name="app_about")
     */
    public function about(): Response
    {
        return $this->render('about/about.html.twig', []);
    }
}
