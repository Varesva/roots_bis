<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès public MAIS reprend les infos du Ctrl adminRestaurant: Annuaire des restaurants du site Roots
/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_restaurant_index", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }

    // sous-categorie : restaurants des cuisines caribbénnes 
    /**
     * @Route("/caraibes", name="app_restaurant_caraibes")
     */
    public function caraibes(RestaurantRepository $restaurantRepository, Restaurant $restaurant): Response
    {
            return $this->render('restaurant/caraibes.html.twig', [
            'restaurants' => $restaurantRepository->findBy(['type_cuisine'=> $restaurant->getRestauration()]),
        ]);
    }

    // public function categ(SproduitRepository $sproduitRepository, Sproduit $sproduit): Response
    // {

    //     return $this->render('admin_sproduit/index.html.twig', [
    //         'sproduits' => $sproduitRepository->findby(['id' => $sproduit->getId()]),
    //     ]);
    // }

    // sous-categorie : restaurants des cuisines africaines 
    /**
     * @Route("/caraibes", name="app_restaurant_afrique")
     */
    public function afrique(Request $request, RestaurantRepository $restaurantRepository): Response
    {
        
        return $this->render('restaurant/afrique.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
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

    /**
     * @Route("/{id}/edit", name="app_restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Restaurant $restaurant, RestaurantRepository $restaurantRepository): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantRepository->add($restaurant);
            return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, Restaurant $restaurant, RestaurantRepository $restaurantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $restaurantRepository->remove($restaurant);
        }

        return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
