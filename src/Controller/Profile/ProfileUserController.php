<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/profile/mon-profil-personnel")
 */
class ProfileUserController extends AbstractController
{
    private $security;
    private $userRepository;
    private $emailService;
    private $entityManager;

    public function __construct(Security $security, UserRepository $userRepository, EmailService $emailService, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->emailService = $emailService;
        $this->entityManager = $entityManager;
    }

    // ACCES PROFIL PERSONNEL
    /**
     * @Route("/", name="app_profile_user")
     */
    public function profile(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // SECURISATION ID URL
        $this->security->getUser();

        return $this->render('profile_user/profile.html.twig', []);
    }

    // MODIFIER INFO PERSO
    /**
     * @Route("/{id}/modifier-mes-informations", name="app_profile_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // SECURISATION ID URL
        $user = $this->security->getUser();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->remove('roles');
        $userForm->remove('password');
        $userForm->remove('isVerified');

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $this->userRepository->add($user);

            $this->addFlash('success', 'Modification(s) enregistrée(s) !');

            return $this->redirectToRoute('app_profile_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile_user/edit.html.twig', [
            'user' => $user,
            'userForm' => $userForm,
        ]);
    }

    // ENVOYER EMAIL DE CONFIRMATION DE MODIFICATION
    // public function profileEditSendEmail() {

    //     // $userForm = $this->createForm(UserType::class, $user);

    //     // $ok_userForm = $userForm->getData();
    //     $ok_email = '' ;

    //     $noReplySubject = 'Modification de vos informations personnelles';

    //     $emailTemplate = 'email/profile_user_edit_email.html.twig';

    //     // ENVOI MAIL AUTO CONTACT - ACCUSE DE RECEPTION
    //     $this->emailService->sendNoReply(
    //         $recipient = $ok_email,
    //         $noReplySubject,
    //         $ok_email,
    //         $emailTemplate
    //     );

    //     return $recipient;
    // }


    // MODIFIER MOT DE PASSE
    /**
     * @Route("/{id}/modifier-mot-de-passe", name="app_profile_user_edit_pwd", methods={"GET", "POST"})
     */
    public function editPwd(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // SECURISATION ID URL
        $this->security->getUser();

        $form = $this->createForm(ChangePasswordFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Encode(hash) the plain password, and set it.
            $encodedPassword = $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            $this->addFlash('success', 'Mot de passe modifié !');

            return $this->redirectToRoute('app_profile_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile_user/edit.html.twig', [
            'user' => $user,
            'userForm' => $form,
        ]);
    }

    // DEMANDE SUPPRESSION DE COMPTE
    /**
     * @Route("/supprimer-mon-compte", name="app_profile_user_delete_request", methods={"GET"})
     */
    public function deleteProfileRequest()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // SECURISATION ID URL
        $this->security->getUser();

        return $this->render('profile_user/delete_request.html.twig', []);
    }

    // CONFIRMATION SUPPRESSION DE COMPTE
    /**
     * @Route("/{id}/compte-supprime", name="app_profile_user_delete", methods={"POST"})
     */
    public function deleteProfileConfirm(Request $request, User $user, TokenStorageInterface $tokenStorage): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // SECURISATION ID URL
        $this->security->getUser();

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            $this->userRepository->remove($user);
        }

        // équivalent de session_destroy() : https://symfony.com/doc/current/components/http_foundation/sessions.html#session-workflow 
        $request->getSession()->invalidate();

        $tokenStorage->setToken(); // TokenStorageInterface

        $this->addFlash('success', 'Votre compte Roots a été supprimé avec succès');

        return $this->redirectToRoute('app_home', []);
    }
}
