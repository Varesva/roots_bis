<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public MAIS reprend les infos du Ctrl adminRestaurant: Annuaire des restaurants du site Roots
/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    // constructeur de classe  - pour tjrs avoir ces variables avec la classe
    protected $restaurantRepository;
    protected $em;

    public function __construct(RestaurantRepository  $restaurantRepository, EntityManagerInterface $em)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->entityManagerInterface = $em;
    }
    // fin constructeur de classe  

    // afficher tous les restaurants
    /**
     * @Route("/", name="app_restaurant_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $this->restaurantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    // afficher toutes les restaurants d'une catégorieRestaurant afrique
    /**
     * @Route("/cuisines-africaines/{id}", name="app_restaurant_afrique", methods={"GET"})
     */
    public function showByCategAfrique($id): Response
    {
        // récuperer tous les restaurants africains
        $restaurantAfrique = $this->restaurantRepository->findBy(
            ['categorie' => $id]
        );
        // retourner la vue
        return $this->render('restaurant/afrique.html.twig', 
        [
            'restaurants' => $restaurantAfrique,
        ]);
    }

    // afficher toutes les restaurants d'une catégorieRestaurant caribéens
    /**
     * @Route("/cuisines-caribeennes/{id}", name="app_restaurant_carib", methods={"GET"})
     */
    public function showByCategCarib($id): Response
    {
        // récuperer tous les restaurants carib
        $restaurantCarib = $this->restaurantRepository->findBy(
            ['categorie' => $id]
        );
        // retourner la vue
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
        // récuperer tous les produits de la categorie séléctionnée
    
        $restaurantRepository = $this->restaurantRepository->findBy(
            ['nutrition' => $id]
        );

        // retourner la vue
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository,
        ]);
    }
}
