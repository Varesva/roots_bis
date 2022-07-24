<?php

namespace App\Controller;

ob_end_clean();

use App\Form\RecommanderType;
use App\Service\Email\EmailService;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecommanderController extends AbstractController
{
    protected $fileUploader;
    protected $emailService;

    public function __construct(FileUploader $fileUploader, EmailService $emailService)
    {
        $this->fileUploader = $fileUploader;
        $this->emailService = $emailService;
        $this->adminSubject = 'Recommandation de restaurant';
        $this->adminEmailTemplate = 'email/recommend_by_email_to_admin.html.twig';
    }

    /**
     * @Route("/recommander-un-restaurant", name="app_recommander")
     */
    public function recommend(Request $request): Response
    {
        $recommendForm = $this->createForm(RecommanderType::class);

        $recommendForm->handleRequest($request);

        if ($recommendForm->isSubmitted() && $recommendForm->isValid() && $_SERVER['CONTENT_LENGTH'] < 8380000) {

            $ok_recommendForm = $recommendForm->getData();

            // USER
            $ok_UserEmail = $ok_recommendForm['email'];

            // ADMIN 
            $attachementName = $ok_recommendForm['restaurant'];

            // UPLOAD ATTACHEMENTS
            $file = $recommendForm->get('attachement')->getData();

            if ($file) {
                // foreach ($files as $file) {
                    $directory = 'recommend';

                    $uploaded_files = $this->fileUploader->upload($file, $directory);

                    $attachement = 'recommendAttachement/' . $uploaded_files;

                    // $attachement = implode($attach);
                // }
                // $a = '';
                //                 foreach ([$attachement] as $k => $v) {
                //                     $a = json_encode($v) ;

                //                 }
                // dd($attachement);

                // $a = implode(',', $attachement);

                // foreach($files as $key => $value) {
                // $attachement = $value['original']
                // }

                // for($i = 0; $i; $i++) {


                // ENVOI EMAIL ADMIN + ATTACHEMENTS : NOUVEAU TICKET UTILISATEUR
                $this->emailService->sendAdminEmailWithAttachement(
                    $ok_UserEmail,
                    $this->adminSubject,
                    $ok_recommendForm,
                    $attachement,
                    $attachementName,
                    $this->adminEmailTemplate,
                );
            // }

                // dd($attachement);
            } else {
                // ENVOI EMAIL ADMIN : NOUVEAU TICKET UTILISATEUR
                $this->emailService->sendAdminEmail(
                    $ok_UserEmail,
                    $this->adminSubject,
                    $ok_recommendForm,
                    $this->adminEmailTemplate,
                );
            };

            $this->addFlash('success', 'Recommandation envoyée ! L\'équipe Roots vous remercie !');

            return $this->redirectToRoute('app_restaurant_index');

            // return $this->renderForm('recommander/confirm.html.twig', [
            //     // DONNEES POUR L'EMAIL
            //     // 'data' => $ok_recommendForm,
            //     // 'attachement' => $file,
            // ]);
            
        } elseif ($recommendForm->isSubmitted() && $_SERVER['CONTENT_LENGTH'] > 8380000) {

            $this->addFlash('uploadFile_error', 'Impossible de télécharger ce fichier. Veuillez réessayer');

            return $this->renderForm('recommander/index.html.twig', [
                'recommendForm' => $recommendForm,
            ]);
        } else {

            return $this->renderForm('recommander/index.html.twig', [
                'recommendForm' => $recommendForm,
            ]);
        };
    }
}
