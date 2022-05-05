<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Entity\CategorieRestaurant;
use App\Form\CategorieRestaurantType;
use App\Repository\CategorieRestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès privé ADMIN : catégorie Restaurant : type de catégorie de cuisines des livres et restaurants du site (carib ou afrique)
/**
 * @Route("/admin/categorie-restaurant")
 */
class AdminCategorieRestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_categorie_restaurant_index", methods={"GET"})
     */
    public function index(CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        return $this->render('admin_categorie_restaurant/index.html.twig', [
            'categorie_restaurants' => $categorieRestaurantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_categorie_restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        $categorieRestaurant = new CategorieRestaurant();
        $form = $this->createForm(CategorieRestaurantType::class, $categorieRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRestaurantRepository->add($categorieRestaurant);
            return $this->redirectToRoute('app_admin_categorie_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_categorie_restaurant/new.html.twig', [
            'categorie_restaurant' => $categorieRestaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_categorie_restaurant_show", methods={"GET"})
     */
    public function show(CategorieRestaurant $categorieRestaurant): Response
    {
        return $this->render('admin_categorie_restaurant/show.html.twig', [
            'categorie_restaurant' => $categorieRestaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_categorie_restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CategorieRestaurant $categorieRestaurant, CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        $form = $this->createForm(CategorieRestaurantType::class, $categorieRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRestaurantRepository->add($categorieRestaurant);
            return $this->redirectToRoute('app_admin_categorie_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_categorie_restaurant/edit.html.twig', [
            'categorie_restaurant' => $categorieRestaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_categorie_restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, CategorieRestaurant $categorieRestaurant, CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieRestaurant->getId(), $request->request->get('_token'))) {
            $categorieRestaurantRepository->remove($categorieRestaurant);
        }

        return $this->redirectToRoute('app_admin_categorie_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
