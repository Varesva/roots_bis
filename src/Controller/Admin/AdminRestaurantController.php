<?php
namespace App\Controller\Admin;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Service\FileUploader;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/restaurant")
 */
class AdminRestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_restaurant_index", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('admin_restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }
    // afficher les restaurants par type de categorie de cuisine
    /**
     * @Route("/{id}/afficher", name="app_admin_restaurant_categorie", methods={"GET"})
     */
    public function showRestoByCategorie($id, RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('admin_restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findBy(['categorie' => $id]),
        ]);
    }

    // ajouter un restaurant
    /**
     * @Route("/new", name="app_admin_restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RestaurantRepository $restaurantRepository, FileUploader $fileUploader): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** 
             * @var UploadedFile $image 
             */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            if ($imageFile) {
                $directory = 'content';

                $image = $fileUploader->upload($imageFile, $directory); // l'upload du fichier
                $restaurant->setImage($image);  // le nom du fichier 

                $restaurantRepository->add($restaurant);
                return $this->redirectToRoute('app_admin_restaurant_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin_restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }
    // afficher un restaurant
    /**
     * @Route("/{id}", name="app_admin_restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('admin_restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }
    // modifier un restaurant
    /**
     * @Route("/{id}/edit", name="app_admin_restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Restaurant $restaurant, FileUploader $fileUploader, RestaurantRepository $restaurantRepository): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** 
             * @var UploadedFile $image 
             */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $directory = 'content';

                $image = $fileUploader->upload($imageFile, $directory); 

                $restaurant->setImage($image);  // le nom du fichier 

                $restaurantRepository->add($restaurant);
                return $this->redirectToRoute('app_admin_restaurant_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin_restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }
    // supprimer un restaurant
    /**
     * @Route("/{id}", name="app_admin_restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, Restaurant $restaurant, RestaurantRepository $restaurantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $restaurant->getId(), $request->request->get('_token'))) {
            $restaurantRepository->remove($restaurant);
        }

        return $this->redirectToRoute('app_admin_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
