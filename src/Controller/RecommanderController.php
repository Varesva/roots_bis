<?php

namespace App\Controller;

use App\Form\RecommanderType;
use App\Service\Email\EmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Intl\Scripts;

class RecommanderController extends AbstractController
{
    /**
     * @Route("/recommander-un-restaurant", name="app_recommander")
     */
    public function recommend(Request $request, EmailService $emailService): Response
    {
        $recommendForm = $this->createForm(RecommanderType::class);

        $recommendForm->handleRequest($request);

        if ($recommendForm->isSubmitted() && $recommendForm->isValid()) {

            // USER
            $ok_recommendForm = $recommendForm->getData();

            $ok_email = $ok_recommendForm['email'];

            $noReplySubject = 'Recommandation prise en compte';

            $emailTemplate = 'email/recommend_email.html.twig';

            // ADMIN
            $adminEmailTemplate = 'email/recommend_by_email_to_admin.html.twig';

            $subjectRecommend =  'Nouveau ticket utilisateur : Recommandation de restaurant';

            // ENVOI EMAIL ADMIN : NOUVEAU TICKET UTILISATEUR
            $emailService->sendAdminEmail(
                $sender = $ok_email,
                $subjectRecommend,
                $data = $ok_recommendForm,
                $adminEmailTemplate,
            );

            // ENVOI MAIL AUTO RECOMMANDATION - ACCUSE DE RECEPTION
            $emailService->sendNoReply(
                $recipient = $ok_email,
                $noReplySubject,
                $ok_recommendForm,
                $emailTemplate,
            );

            return $this->renderForm('recommander/confirm.html.twig', [
                $sender,
                $recipient,
                'data' => $data,
            ]);

        } else {

            return $this->renderForm('recommander/index.html.twig', [
                'recommendForm' => $recommendForm,
            ]);
        }
    }
}
