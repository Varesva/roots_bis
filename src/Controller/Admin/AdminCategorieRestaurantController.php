<?php
namespace App\Controller\Admin;

use App\Service\FileUploader;
use App\Entity\CategorieRestaurant;
use App\Form\CategorieRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/categorie-restaurant")
 */
class AdminCategorieRestaurantController extends AbstractController
{
    protected $categorieRestaurantRepository;
    protected $fileUploader;
    protected $em;

    public function __construct(CategorieRestaurantRepository $categorieRestaurantRepository, FileUploader $fileUploader, EntityManagerInterface $em)
    {
        $this->categorieRestaurantRepository = $categorieRestaurantRepository;
        $this->fileUploader = $fileUploader;
        $this->entityManagerInterface = $em;
    }

    /**
     * @Route("/", name="app_admin_categorie_restaurant_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_categorie_restaurant/index.html.twig', [
            'categorie_restaurants' => $this->categorieRestaurantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_categorie_restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $categorieRestaurant = new CategorieRestaurant();

        $form = $this->createForm(CategorieRestaurantType::class, $categorieRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** 
             * @var UploadedFile $image 
             */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the image/photo field is not required
            if ($imageFile) {
                $image = $this->fileUploader->upload($imageFile); // l'upload du fichier
                $categorieRestaurant->setImage($image);  
            }

            $this->categorieRestaurantRepository->add($categorieRestaurant);

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
    public function edit(Request $request, CategorieRestaurant $categorieRestaurant): Response
    {
        $form = $this->createForm(CategorieRestaurantType::class, $categorieRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** 
             * @var UploadedFile $image 
             */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the image/photo field is not required

            if ($imageFile) {
                $image = $this->fileUploader->upload($imageFile); // l'upload du fichier
                $categorieRestaurant->setImage($image);  
            }
            
            $this->categorieRestaurantRepository->add($categorieRestaurant);

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
    public function delete(Request $request, CategorieRestaurant $categorieRestaurant): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorieRestaurant->getId(), $request->request->get('_token'))) {
            $this->categorieRestaurantRepository->remove($categorieRestaurant);
        }

        return $this->redirectToRoute('app_admin_categorie_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
