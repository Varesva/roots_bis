<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Entity\Nutrition;
use App\Repository\NutritionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès privé PROFILE (user), reprend les infos du Ctrl adminNutrition  : regimes alimentaires des livres et restaurants du site
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

}
