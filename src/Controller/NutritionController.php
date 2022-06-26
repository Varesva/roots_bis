<?php
namespace App\Controller;

use App\Entity\Nutrition;
use App\Repository\NutritionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nutrition")
 */
class NutritionController extends AbstractController
{
    /**
     * @Route("/", name="app_nutrition_index", methods={"GET"})
     */
    public function index(NutritionRepository $nutritionRepository): Response
    {
        return $this->render('nutrition/index.html.twig', [
            'nutrition' => $nutritionRepository->findAll(),
        ]);
    }

}
