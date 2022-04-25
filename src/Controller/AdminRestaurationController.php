<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Entity\Restauration;
use App\Form\RestaurationType;
use App\Repository\RestaurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès privé ADMIN : catégorie Restauration : type de catégorie de cuisines des livres et restaurants du site (carib ou afrique)
/**
 * @Route("/admin/restauration")
 */
class AdminRestaurationController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_restauration_index", methods={"GET"})
     */
    public function index(RestaurationRepository $restaurationRepository): Response
    {
        return $this->render('admin_restauration/index.html.twig', [
            'restaurations' => $restaurationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_restauration_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RestaurationRepository $restaurationRepository): Response
    {
        $restauration = new Restauration();
        $form = $this->createForm(RestaurationType::class, $restauration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurationRepository->add($restauration);
            return $this->redirectToRoute('app_admin_restauration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_restauration/new.html.twig', [
            'restauration' => $restauration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_restauration_show", methods={"GET"})
     */
    public function show(Restauration $restauration): Response
    {
        return $this->render('admin_restauration/show.html.twig', [
            'restauration' => $restauration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_restauration_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Restauration $restauration, RestaurationRepository $restaurationRepository): Response
    {
        $form = $this->createForm(RestaurationType::class, $restauration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurationRepository->add($restauration);
            return $this->redirectToRoute('app_admin_restauration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_restauration/edit.html.twig', [
            'restauration' => $restauration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_restauration_delete", methods={"POST"})
     */
    public function delete(Request $request, Restauration $restauration, RestaurationRepository $restaurationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restauration->getId(), $request->request->get('_token'))) {
            $restaurationRepository->remove($restauration);
        }

        return $this->redirectToRoute('app_admin_restauration_index', [], Response::HTTP_SEE_OTHER);
    }
}
