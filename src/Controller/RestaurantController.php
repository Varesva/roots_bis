<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller accès public : catalogue des restaurants

/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    protected $restaurantRepository;
    protected $em;

    public function __construct(RestaurantRepository  $restaurantRepository, EntityManagerInterface $em)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->entityManagerInterface = $em;
    }

    // AFFICHER TOUS LES RESTOS
    /**
     * @Route("/catalogue-complet", name="app_restaurant_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $this->restaurantRepository->findAll(),
        ]);
    }

    // AFFICHER UN RESTO
    /**
     * @Route("/{id}", name="app_restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    // AFFICHER TOUS RESTOS CATEGRESTAURANT Afrique
    /**
     * @Route("/cuisines-africaines/{id}", name="app_restaurant_afrique", methods={"GET"})
     */
    public function showByCategAfrique($id): Response
    {
        $restaurantAfrique = $this->restaurantRepository->findBy(
            ['categorie' => $id]
        );
        return $this->render(
            'restaurant/afrique.html.twig',
            [
                'restaurants' => $restaurantAfrique,
            ]
        );
    }

    // AFFICHER TOUS RESTOS CATEGRESTAURANT Caribéens
    /**
     * @Route("/cuisines-caribeennes/{id}", name="app_restaurant_carib", methods={"GET"})
     */
    public function showByCategCarib($id): Response
    {
        $restaurantCarib = $this->restaurantRepository->findBy(
            ['categorie' => $id]
        );
        return $this->render('restaurant/carib.html.twig', [
            'restaurants' => $restaurantCarib,
        ]);
    }

    // afficher tous les livres selon régime alimentaire
    /**
     * @Route("/types-alimentations/{id}", name="app_restaurant_ByCateg_nutrition", methods={"GET"})
     */

    public function showByRestoNutrition($id): Response
    {
        $restaurantRepository = $this->restaurantRepository->findBy(
            ['nutrition' => $id]
        );

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository,
        ]);
    }
}
