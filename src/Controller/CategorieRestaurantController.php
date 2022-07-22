<?php

namespace App\Controller;

use App\Entity\CategorieRestaurant;
use App\Form\CategorieRestaurantType;
use App\Repository\CategorieRestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories-restaurants")
 */
class CategorieRestaurantController extends AbstractController
{
        // AFFICHER TOUTES CATEGRESTAU = types de cuisines (afr, carib)
    /**
     * @Route("/", name="app_categorie_restaurant_index", methods={"GET"})
     */
    public function index(CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        return $this->render('categorie_restaurant/categories.html.twig', [
            'categorie_restaurant' => $categorieRestaurantRepository->findAll(),
        ]);
    }

}
