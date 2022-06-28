<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/commande")
 */
class AdminCommandeController extends AbstractController
{
    private $commandeRepository;

    public function __construct(CommandeRepository $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    // afficher les commandes dans l'ordre décroissant
    /**
     * @Route("/", name="app_admin_commande_index", methods={"GET"})
     */
    public function indexDesc(): Response
    {
        return $this->render('admin_commande/index.html.twig', [
            'commandes' => $this->commandeRepository->findByAllCommande($this->commandeRepository),
        ]);
    }

    // afficher les commandes dans l'ordre croissant
    public function indexAsc(): Response
    {
        return $this->render('admin_commande/index.html.twig', [
            'commandes' => $this->commandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $commande = new Commande();

        // $user = $this->security->getUser();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->commandeRepository->add($commande);

            return $this->redirectToRoute('app_admin_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_commande_show", methods={"GET"})
     */
    public function show(Commande $commande, LigneCommandeRepository $ligneCommandeRepository, $id): Response
    {
        return $this->render('admin_commande/show.html.twig', [
            'commande' => $commande,

            'ligne_commandes' => $ligneCommandeRepository->findBy(['commande' => $id]),
        ]);
    }

    // afficher le user lié à la commande
    /**
     * @Route("/client/{id}", name="app_admin_commande_user", methods={"GET"})
     */
    public function showUserCommande($id, User $user): Response
    {

        return $this->render('admin_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->add($commande);
            return $this->redirectToRoute('app_admin_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande);
        }

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

        return $this->redirectToRoute('app_admin_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
