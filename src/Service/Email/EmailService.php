<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Service\Email;

// auto-wiring
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService {
    // constructeur de classe EmailService - pour tjrs avoir ces variables avec la classe
    protected $varEmail;
    public function __construct(MailerInterface $mailer)
    {
        $this->varEmail = $mailer;
    }
    // fin constructeur de classe Cart 

    // envoi de mails automatiques grâce à la fonction sendEmail()
    public function sendEmail($recipient, $subject, $data, $htmlTemplate){
        // instanciation de la classe TemplatedEmail
        $email = new TemplatedEmail(); 
        // définition des paramètres de l'email à envoyer par le Mailer
        $email
            ->from(new Address('contact@roots.com', 'Roots')) // expéditeur

            ->to($recipient)     // destinataire

            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)

            ->subject($subject) // le nom de l'objet du mail qui sera envoyé
            // les diverses infos et autres variables qui peuvent être contenus dans les mails envoyés
            ->context([
                //date d'expiration des liens contenus dans les mails par exemple 
                'expiration_date' => new \DateTime('+7 days'),   
                //reprise des infos liées au controller où le service est appelé,
                'valid_contact_email' => $recipient,
                'valid_contact_form' => $data,
            ])
            // le nom du fichier qui sera retourné dans le ctrl
            ->htmlTemplate($htmlTemplate);   

        // appel du mailer (contenu dans varEmail - dans le constructeur de classe) en paramètre de la fonction et envoyer le mail contenu dans la variable $email
        $this->varEmail->send($email);
    }
}