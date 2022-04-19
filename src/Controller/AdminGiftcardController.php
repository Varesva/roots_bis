<?php

namespace App\Controller;

use App\Entity\Giftcard;
use App\Form\GiftcardType;
use App\Repository\GiftcardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/giftcard")
 */
class AdminGiftcardController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_giftcard_index", methods={"GET"})
     */
    public function index(GiftcardRepository $giftcardRepository): Response
    {
        return $this->render('admin_giftcard/index.html.twig', [
            'giftcards' => $giftcardRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_giftcard_new", methods={"GET", "POST"})
     */
    public function new(Request $request, GiftcardRepository $giftcardRepository): Response
    {
        $giftcard = new Giftcard();
        $form = $this->createForm(GiftcardType::class, $giftcard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $giftcardRepository->add($giftcard);
            return $this->redirectToRoute('app_admin_giftcard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_giftcard/new.html.twig', [
            'giftcard' => $giftcard,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_giftcard_show", methods={"GET"})
     */
    public function show(Giftcard $giftcard): Response
    {
        return $this->render('admin_giftcard/show.html.twig', [
            'giftcard' => $giftcard,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_giftcard_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Giftcard $giftcard, GiftcardRepository $giftcardRepository): Response
    {
        $form = $this->createForm(GiftcardType::class, $giftcard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $giftcardRepository->add($giftcard);
            return $this->redirectToRoute('app_admin_giftcard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_giftcard/edit.html.twig', [
            'giftcard' => $giftcard,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_giftcard_delete", methods={"POST"})
     */
    public function delete(Request $request, Giftcard $giftcard, GiftcardRepository $giftcardRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$giftcard->getId(), $request->request->get('_token'))) {
            $giftcardRepository->remove($giftcard);
        }

        return $this->redirectToRoute('app_admin_giftcard_index', [], Response::HTTP_SEE_OTHER);
    }
}
