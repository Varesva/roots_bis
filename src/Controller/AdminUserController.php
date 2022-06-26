<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès privé ADMIN : Liste des utilisateurs (User) du site et leur role (admin ou user)
/**
 * @Route("/admin/user")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->render('admin_user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

     // public function findByCaribRestaurant(int $id)
    // {
    //     $entityManager = $this->getEntityManager();
    //     $caribRestaurant = $entityManager->createQuery(
    //         'SELECT c
    //         FROM App\Entity\Restauration c
    //         WHERE c.id :2
    //         ORDER BY c.id ASC'
    //     )->setParameter('id', $id);

    //     return $caribRestaurant->getResult();
            // return $this->createQueryBuilder('c')

            //     ->andWhere('c.id = :2')
            //     ->setParameter('2', $type_cuisine)
            //     ->orderBy('r.id', 'ASC')
            //     ->setMaxResults(10)
            //     ->getQuery()
            //     ->getResult()
    //     ;
    // }
 
    /**
     * @Route("/new", name="app_admin_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
