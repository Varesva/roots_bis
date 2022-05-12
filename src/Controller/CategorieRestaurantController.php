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
 * @Route("/categories")
 */
class CategorieRestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_categorie_restaurant_index", methods={"GET"})
     */
    public function index(CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        return $this->render('produit/categorie.html.twig', [
            'categorie_restaurants' => $categorieRestaurantRepository->findAll(),
        ]);
    }

}
