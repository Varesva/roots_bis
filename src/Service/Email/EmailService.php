<?php

namespace App\Service\Email;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    // ENVOI MAIL AUTO UTILISATEUR - ACCUSE DE RECEPTION
    public function sendNoReply($recipient, $noReplySubject, $data, $emailTemplate)
    {
        $atRoots = new Address('contact@leroots.fr', 'Roots');

        $expirationDate = new \DateTime('+7 days');

        $email = new TemplatedEmail();
        $email
            ->from($atRoots)

            ->to($recipient)   // destinataire

            ->subject($noReplySubject)

            ->context([
                'expirationDate' => $expirationDate,
                'data' => $data,
            ])

            ->htmlTemplate($emailTemplate);

        $this->mailer->send($email);
    }

    // ENVOI EMAIL: NOUVEAU TICKET - ADMIN
    public function sendAdminEmail($sender, $subject, $data, $emailTemplate)
    {
        $atRoots = new Address('contact@leroots.fr', 'Roots');

        $expirationDate = new \DateTime('+7 days');

        $email = new TemplatedEmail();
        $email
            ->from($sender)

            ->to($atRoots)     // destinataire

            // ->replyTo($recipient)

            ->priority(Email::PRIORITY_HIGH)

            ->subject($subject)

            ->context([
                'data' => $data,
                'expirationDate' => $expirationDate,
            ])

            ->htmlTemplate($emailTemplate);

        $this->mailer->send($email);
    }

    // ENVOI EMAIL: NOUVEAU TICKET - ADMIN avec PIECE JOINTE
    public function sendAdminEmailWithAttachement($sender, $subject, $data, $attachement, $attachementName, $emailTemplate)
    {
        $atRoots = new Address('contact@leroots.fr', 'Roots');

        $expirationDate = new \DateTime('+7 days');

        $email = new TemplatedEmail();
        $email
            ->from($sender)

            ->to($atRoots)     // destinataire

            // ->replyTo($recipient)

            ->priority(Email::PRIORITY_HIGH)

            ->subject($subject)

            ->context([
                'data' => $data,
                'expirationDate' => $expirationDate,
            ])

            ->attachFromPath($attachement, $attachementName)

            ->htmlTemplate($emailTemplate);

        $this->mailer->send($email);
    }
}
