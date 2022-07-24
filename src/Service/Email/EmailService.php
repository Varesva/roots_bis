<?php

namespace App\Service\Email;

use DateTime;
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
        $this->atRoots = new Address('contact@leroots.fr', 'Roots');
        $this->expirationDate = new DateTime('+7 days');
    }

    // USER - ENVOI MAIL AUTO ACCUSE DE RECEPTION
    public function sendNoReply($recipient, $noReplySubject, $data, $emailTemplate)
    {
        $email = new TemplatedEmail();
        $email
            ->from($this->atRoots)

            ->to($recipient)   // destinataire

            ->subject($noReplySubject)

            ->context([
                'expirationDate' => $this->expirationDate,
                'data' => $data,
            ])

            ->htmlTemplate($emailTemplate);

        $this->mailer->send($email);
    }

    // ADMIN - EMAIL: NOUVEAU TICKET
    public function sendAdminEmail($sender, $subject, $data, $emailTemplate)
    {
        $email = new TemplatedEmail();
        $email
            ->from($sender)

            ->to($this->atRoots)  //destinataire

            ->priority(Email::PRIORITY_HIGH)

            ->subject('Nouveau ticket : ' . $subject)

            ->context([
                'data' => $data,
            ])

            ->htmlTemplate($emailTemplate);

        $this->mailer->send($email);
    }

    // ADMIN - EMAIL + ATTACHEMENT (pièce jointe)
    public function sendAdminEmailWithAttachement($sender, $subject, $data, $attachement, $attachementName, $emailTemplate)
    {
        //            for ($i = 0; $i; $i++) {
        // $attachement[$i];

        //                                    }

        $email = new TemplatedEmail();

        $email
            ->from($sender)

            ->to($this->atRoots) // destinataire

            // ->replyTo($recipient)

            ->priority(Email::PRIORITY_HIGH)

            ->subject('Nouveau ticket : '.$subject)

            ->context([
                'data' => $data,
            ])
            // ESSAYER DE METTRE PLUSIEURS PJ A UN MAIL
            ->attachFromPath('../public/upload/' . $attachement, $attachementName)

            ->htmlTemplate($emailTemplate);


        $this->mailer->send($email);
    }
}
