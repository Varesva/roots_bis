<?php

namespace App\Controller;

use App\Entity\Nutrition;
use App\Form\NutritionType;
use App\Repository\NutritionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/nutrition")
 */
class ProfileNutritionController extends AbstractController
{
    /**
     * @Route("/", name="app_profile_nutrition_index", methods={"GET"})
     */
    public function index(NutritionRepository $nutritionRepository): Response
    {
        return $this->render('profile_nutrition/index.html.twig', [
            'nutrition' => $nutritionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_profile_nutrition_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NutritionRepository $nutritionRepository): Response
    {
        $nutrition = new Nutrition();
        $form = $this->createForm(NutritionType::class, $nutrition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nutritionRepository->add($nutrition);
            return $this->redirectToRoute('app_profile_nutrition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile_nutrition/new.html.twig', [
            'nutrition' => $nutrition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_profile_nutrition_show", methods={"GET"})
     */
    public function show(Nutrition $nutrition): Response
    {
        return $this->render('profile_nutrition/show.html.twig', [
            'nutrition' => $nutrition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_profile_nutrition_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Nutrition $nutrition, NutritionRepository $nutritionRepository): Response
    {
        $form = $this->createForm(NutritionType::class, $nutrition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nutritionRepository->add($nutrition);
            return $this->redirectToRoute('app_profile_nutrition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile_nutrition/edit.html.twig', [
            'nutrition' => $nutrition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_profile_nutrition_delete", methods={"POST"})
     */
    public function delete(Request $request, Nutrition $nutrition, NutritionRepository $nutritionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nutrition->getId(), $request->request->get('_token'))) {
            $nutritionRepository->remove($nutrition);
        }

        return $this->redirectToRoute('app_profile_nutrition_index', [], Response::HTTP_SEE_OTHER);
    }
}