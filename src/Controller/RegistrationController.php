<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Controller d'accès public MAIS lié à la bdd : Page d'inscription (user) sur le site Roots
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // end of encoding the plain password

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
           
            return $this->redirectToRoute('app_home');
        }
        $account_page_name = "Mon compte - Roots";
        $inscription_page_name = "Inscription";
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'account_page_name' => $account_page_name,
            'inscription' => $inscription_page_name
        ]);
    }
}
