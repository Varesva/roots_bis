<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use App\Entity\Restaurant;
use App\Entity\Restauration;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RestaurationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

// Controller d'accès public MAIS reprend les infos du Ctrl adminRestaurant: Annuaire des restaurants du site Roots

class RestaurantController extends AbstractController
{
    // constructeur de classe - pour tjrs avoir ces variables avec la classe
    protected $restaurantRepository;
    protected $restaurationRepository;

    public function __construct(RestaurantRepository $restaurantRepository, RestaurationRepository $restaurationRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->restaurationRepository = $restaurantRepository;
    }
    // fin constructeur de classe 
    // Afficher tous les restaurants
    /**
     * @Route("/restaurant", name="app_restaurant_index", methods={"GET"})
     */
    public function index(): Response
    {
        // récupérer dans la variable tous les restaurants en appellant la fonction construct qui fait appelle à la classe restaurantRepo
        $allRestaurant = $this->restaurantRepository->findAll();
        // retourner la vue
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $allRestaurant,
        ]);
    }

    /**
     * @Route("restaurant/{id}", name="app_restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }


    // sous-categorie : restaurants des cuisines caribbénnes 
    // /**
    //  * @Route("/caraibes", name="app_restaurant_carib"), methods={"GET"})
    //  */
    // public function indexCarib(ManagerRegistry $doctrine, RestaurantRepository $restaurantRepository, Restaurant $restaurant): Response
    // {

    //     // récupérer dans la variable tous les restaurants en appellant la fonction construct qui fait appelle à la classe restaurantRepo

    //     $caribRestaurant = $doctrine->getRepository(Restaurant::class)->findByCaribRestaurant(['restauration_id' => $restaurant->getRestauration(),]);


    //     // retourner la vue
    //     return $this->render('restaurant/caraibes.html.twig', [
    //         'carib' => $caribRestaurant,
    //     ]);
    // }
    // estaurantRepository->findBy(['restauration_id'=>$restaurant->getRestauration()]),
    // sous-categorie : restaurants des cuisines africaines 



}
