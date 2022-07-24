<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\FileUploader;
use App\Service\Email\EmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    protected $fileUploader;
    protected $emailService;

    public function __construct(FileUploader $fileUploader, EmailService $emailService)
    {
        $this->fileUploader = $fileUploader;
        $this->emailService = $emailService;
    }

    /**
     * @Route("/nous-contacter", name="app_contact")
     */
    public function contact(Request $request): Response
    {
        $contactForm = $this->createForm(ContactType::class);

        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid() && $_SERVER['CONTENT_LENGTH'] < 8380000) {

            $ok_contactForm = $contactForm->getData();

            // USER
            $ok_UserEmail = $ok_contactForm['email'];
            $noReplySubject = 'Accusé de réception de votre message';
            $noReplyEmailTemplate = 'email/contact_email.html.twig';

            // USER - ENVOI MAIL AUTO RECOMMANDATION - ACCUSE DE RECEPTION 
            $this->emailService->sendNoReply(
                $ok_UserEmail,
                $noReplySubject,
                $ok_contactForm,
                $noReplyEmailTemplate,
            );

            // ADMIN
            $adminSubjectContact = 'Prise de contact';
            $adminEmailTemplate = 'email/contact_by_email_to_admin.html.twig';
            $attachementName = null;

            // UPLOAD ATTACHEMENTS
            $file = $contactForm->get('attachement')->getData();

            if ($file) {
                // foreach ($files as $file) {
                $directory = 'contact';

                $uploaded_files = $this->fileUploader->upload($file, $directory);

                $attachement = 'contactAttachement/' . $uploaded_files;

                // ENVOI EMAIL ADMIN + ATTACHEMENTS : NOUVEAU TICKET UTILISATEUR
                $this->emailService->sendAdminEmailWithAttachement(
                    $ok_UserEmail,
                    $adminSubjectContact,
                    $ok_contactForm,
                    $attachement,
                    $attachementName,
                    $adminEmailTemplate,
                );
            } else {
                // ADMIN - EMAIL : NOUVEAU TICKET
                $this->emailService->sendAdminEmail(
                    $ok_UserEmail,
                    $adminSubjectContact,
                    $ok_contactForm,
                    $adminEmailTemplate,
                );
            };

            return $this->renderForm(
                'contact/confirm.html.twig',
                [
                    'data' => $ok_contactForm,
                ]
            );
        } elseif ($contactForm->isSubmitted() && $_SERVER['CONTENT_LENGTH'] > 8380000) {

            $this->addFlash('uploadFile_error', 'Impossible de télécharger ce fichier. Veuillez réessayer');

            return $this->renderForm('contact/index.html.twig', [
                'contactForm' => $contactForm,
            ]);
        } else {

            return $this->renderForm('contact/index.html.twig', [
                'contactForm' => $contactForm,
            ]);
        };
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
