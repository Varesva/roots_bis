<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Form\LigneCommandeType;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/lignes")
 */
class AdminLigneCommandeController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_ligne_commande_index", methods={"GET"})
     */
    public function index(LigneCommandeRepository $ligneCommandeRepository, CommandeRepository $commandeRepository): Response
    {
        return $this->render('admin_ligne_commande/index.html.twig', [
            'lignes_commande' => $ligneCommandeRepository->findAll(),
            // 'commande' => $commandeRepository->findOrdersByLC()
        ]);
    }
    // // afficher les produits de la commande par commande
    // /**
    //  * @Route("/{id}", name="app_admin_grouped_ligne_commande", methods={"GET"})
    //  */
    // public function ligneGroupedCommande(LigneCommandeRepository $ligneCommandeRepository,$id): Response
    // {
    //     return $this->render('admin_ligne_commande/index.html.twig', [
    //         'lignes_commande' => $ligneCommandeRepository->findBy(['commande'=>$id]),
    //     ]);
    // }

    /**
     * @Route("/new", name="app_admin_ligne_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LigneCommandeRepository $ligneCommandeRepository): Response
    {
        $ligneCommande = new LigneCommande();
        $form = $this->createForm(LigneCommandeType::class, $ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ligneCommandeRepository->add($ligneCommande);
            return $this->redirectToRoute('app_admin_ligne_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_ligne_commande/new.html.twig', [
            'ligne_commande' => $ligneCommande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_ligne_commande_show", methods={"GET"})
     */
    public function show(LigneCommande $ligneCommande, CommandeRepository $commandeRepository): Response
    {

        $commande = $commandeRepository->findOrdersByLC($ligneCommande);

        $c = $commande[0];
        // dd($c);

        return $this->render('admin_ligne_commande/show.html.twig', [
            'ligne_commande' => $ligneCommande,
            'commande' => $c
        ]);
    }


    /**
     * @Route("/{id}/edit", name="app_admin_ligne_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LigneCommande $ligneCommande, LigneCommandeRepository $ligneCommandeRepository): Response
    {
        $form = $this->createForm(LigneCommandeType::class, $ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ligneCommandeRepository->add($ligneCommande);
            return $this->redirectToRoute('app_admin_ligne_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_ligne_commande/edit.html.twig', [
            'ligne_commande' => $ligneCommande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_ligne_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, LigneCommande $ligneCommande, LigneCommandeRepository $ligneCommandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ligneCommande->getId(), $request->request->get('_token'))) {
            $ligneCommandeRepository->remove($ligneCommande);
        }

        return $this->redirectToRoute('app_admin_ligne_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
