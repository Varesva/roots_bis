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
 * @Route("/cadeau")
 */
class CadeauController extends AbstractController
{
    /**
     * @Route("/", name="app_cadeau_index", methods={"GET"})
     */
    public function index(GiftcardRepository $giftcardRepository): Response
    {
        return $this->render('cadeau/index.html.twig', [
            'giftcards' => $giftcardRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_cadeau_show", methods={"GET"})
     */
    public function show(Giftcard $giftcard): Response
    {
        return $this->render('cadeau/show.html.twig', [
            'giftcard' => $giftcard,
        ]);
    }
}
