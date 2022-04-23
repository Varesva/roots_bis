<?php

namespace App\Controller;

use App\Entity\Boutique;
use App\Form\BoutiqueType;
use App\Repository\BoutiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/boutique")
 */
class AdminBoutiqueController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_boutique_index", methods={"GET"})
     */
    public function index(BoutiqueRepository $boutiqueRepository): Response
    {
        return $this->render('admin_boutique/index.html.twig', [
            'boutiques' => $boutiqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_boutique_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BoutiqueRepository $boutiqueRepository): Response
    {
        $boutique = new Boutique();
        $form = $this->createForm(BoutiqueType::class, $boutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boutiqueRepository->add($boutique);
            return $this->redirectToRoute('app_admin_boutique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_boutique/new.html.twig', [
            'boutique' => $boutique,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_boutique_show", methods={"GET"})
     */
    public function show(Boutique $boutique): Response
    {
        return $this->render('admin_boutique/show.html.twig', [
            'boutique' => $boutique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_boutique_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Boutique $boutique, BoutiqueRepository $boutiqueRepository): Response
    {
        $form = $this->createForm(BoutiqueType::class, $boutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boutiqueRepository->add($boutique);
            return $this->redirectToRoute('app_admin_boutique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_boutique/edit.html.twig', [
            'boutique' => $boutique,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_boutique_delete", methods={"POST"})
     */
    public function delete(Request $request, Boutique $boutique, BoutiqueRepository $boutiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boutique->getId(), $request->request->get('_token'))) {
            $boutiqueRepository->remove($boutique);
        }

        return $this->redirectToRoute('app_admin_boutique_index', [], Response::HTTP_SEE_OTHER);
    }
}
