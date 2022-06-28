<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

// Controller d'accès privé PROFILE (user), reprend les infos du Ctrl adminUser : Profil personnel d'utilisateur inscrit (User), et son propre CRUD pour gérer les paramètres de son compte sur Roots
/**
 * @Route("/profile/user")
 */
class ProfileUserController extends AbstractController
{
    // /**
    //  * @Route("/", name="app_profile_user_index", methods={"GET"})
    //  */
    // public function index(UserRepository $userRepository): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');       

    //     return $this->render('profile_user/index.html.twig', [
    //         'users' => $userRepository->findAll(),
    //     ]);
    // }


    // accéder à l'espace personnel
    /**
     * @Route("/", name="app_profile_user_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('profile_user/profile.html.twig', []);
    }

    /**
     * @Route("/", name="app_profile_user_show", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('profile_user/show.html.twig', []);
    }

    /**
     * @Route("/modifier-mes-informations/{id}", name="app_profile_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(UserType::class, $user);
        $form->remove('roles');
        $form->remove('password');
        $form->remove('isVerified');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->add($user);

            return $this->redirectToRoute('app_profile_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/supprimer-mon-compte/{id}", name="app_profile_delete", methods={"GET"})
     */
    public function deleteProfile()
    {
        return $this->render('profile_user/confirm_delete.html.twig', []);
    }

    /**
     * @Route("/confirmation-de-suppression/{id}", name="app_profile_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository, TokenStorageInterface $tokenStorage): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            
            $userRepository->remove($user);
        }

        $request->getSession()->invalidate();

        $tokenStorage->setToken(); // TokenStorageInterface

        // $security->logout();

        // header("refresh:6;url=profile_user/deleted.html.twig");

        $this->addFlash('success', 'Votre compte Roots a été supprimé avec succès');

        return $this->redirectToRoute('app_home', []);
      
        // exit;
    }
}
