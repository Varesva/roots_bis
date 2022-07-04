<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\LigneCommande;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/commande")
 */
class AdminCommandeController extends AbstractController
{
    private $commandeRepository;
    private $security;

    public function __construct(CommandeRepository $commandeRepository, Security $security)
    {
        $this->commandeRepository = $commandeRepository;
        $this->security = $security;
    }

    // afficher les commandes dans l'ordre décroissant
    /**
     * @Route("/", name="app_admin_commande_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_commande/index.html.twig', [
            'commandes' => $this->commandeRepository->findAllByDesc(),

        ]);
    }

    // afficher les commandes dans l'ordre croissant - fonction de tri à ajouter ----
    // public function allOrdersByAsc(): Response
    // {
    //     return $this->render('admin_commande/index.html.twig', [
    //         'commandes' => $this->commandeRepository->findAll(),
    //     ]);
    // }


    /**
     * @Route("/new", name="app_admin_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $this->security->getUser();

        $commande = new Commande();

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
     * @Route("/{id}/afficher", name="app_admin_commande_show", methods={"GET"})
     */
    public function show(Commande $commande, LigneCommandeRepository $ligneCommandeRepository, $id, ProduitRepository $produitRepository): Response
    {
        // $this->security->getUser();
        return $this->render('admin_commande/show.html.twig', [
            'commande' => $commande,
            'lignes_commande' => $ligneCommandeRepository->findLignesByOrder($id),
        ]);
    }

    // afficher le user lié à la commande
    /**
     * @Route("/{id}/client", name="app_admin_commande_user", methods={"GET"})
     */
    public function showUserFromOrder(): Response
    {
        // $this->security->getUser();
        return $this->render('admin_user/show.html.twig', []);
    }

    // afficher le produit lié à la commande
    /**
     * @Route("/{id}/produit", name="app_admin_commande_produit", methods={"GET"})
     */
    public function showProductFromOrder(): Response
    {
        // $this->security->getUser();
        return $this->render('admin_produit/show.html.twig', []);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $this->security->getUser();

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandeRepository->add($commande);

            $this->addFlash('success', 'L\'utilisateur a bien été modifié');

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
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $this->commandeRepository->remove($commande);
        }

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

        return $this->redirectToRoute('app_admin_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
