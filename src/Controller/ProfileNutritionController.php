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
     * @Route("/{id}", name="app_profile_nutrition_show", methods={"GET"})
     */
    public function show(Nutrition $nutrition): Response
    {
        return $this->render('profile_nutrition/show.html.twig', [
            'nutrition' => $nutrition,
        ]);
    }


}
