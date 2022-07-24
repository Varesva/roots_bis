<?php
namespace App\Controller;

ob_get_contents();
// ob_end_clean();

use App\Form\FileUploadType;
use App\Form\RecommanderType;
use App\Service\Email\EmailService;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecommanderController extends AbstractController
{
    protected $fileUploader;
    protected $emailService;

    public function __construct( FileUploader $fileUploader, EmailService $emailService)
    {
        $this->fileUploader = $fileUploader;
        $this->emailService = $emailService;
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
// dd($ok_recommendForm);

            $files = $recommendForm->get('attachement')->getData();
       //   dd($files);   // RETOURNE UN ARRAY

            // $attachementFile = $recommendForm->get('attachement')->getData();

            if ($files) {
                foreach ($files as $file) {
                    $directory = 'recommend';

                    $uploaded_files = $this->fileUploader->upload($file, $directory);
                }
            }
            // dd($files);


            // // USER
            // $ok_email = $ok_recommendForm['email'];

            // $noReplySubject = 'Recommandation prise en compte';

            // $emailTemplate = 'email/recommend_email.html.twig';

            // // ADMIN
            // $adminEmailTemplate = 'email/recommend_by_email_to_admin.html.twig';

            // $subjectRecommend =  'Nouveau ticket : Recommandation de restaurant';

            // if ($attachementFile) {
            
            //     $directory = 'recommend';

            //     $uploaded = $this->fileUploader->upload($attachementFile, $directory);

            //     $attachement = '../public/upload/recommendAttachement/' . $uploaded;

            //     $attachementName = $ok_recommendForm['restaurant'];


            //     // ENVOI EMAIL ADMIN : NOUVEAU TICKET UTILISATEUR
            //     $emailService->sendAdminEmailWithAttachement(
            //         $sender = $ok_email,
            //         $subjectRecommend,
            //         $data = $ok_recommendForm,
            //         $attachement,
            //         $attachementName,
            //         $adminEmailTemplate,
            //     );
            // } else {

            //     // ENVOI EMAIL ADMIN : NOUVEAU TICKET UTILISATEUR
            //     $emailService->sendAdminEmail(
            //         $sender = $ok_email,
            //         $subjectRecommend,
            //         $data = $ok_recommendForm,
            //         $adminEmailTemplate,
            //     );
            // }
            // dd($data['attachement']);
            // $file = $fileUploader->;
            // dd($file);
            // // ENVOI MAIL AUTO RECOMMANDATION - ACCUSE DE RECEPTION
            // $emailService->sendNoReply(
            //     $recipient = $ok_email,
            //     $noReplySubject,
            //     $ok_recommendForm,
            //     $emailTemplate,
            // );
            return $this->renderForm('recommander/confirm.html.twig', [
                // $sender,
                // // $recipient,
                // 'data' => $data,
                // 'attachement' => $attachementFile,
            ]);
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
