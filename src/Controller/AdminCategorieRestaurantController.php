<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Service\FileUploader;
use App\Entity\CategorieRestaurant;
use App\Form\CategorieRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès privé ADMIN : catégorie Restaurant : type de catégorie de cuisines des livres et restaurants du site (carib ou afrique)
/**
 * @Route("/admin/restaurant/categorie")
 */
class AdminCategorieRestaurantController extends AbstractController
{
    // constructeur de classe  - pour tjrs avoir ces variables avec la classe
    protected $categorieRestaurantRepository;
    protected $fileUploader;
    protected $em;

    public function __construct(CategorieRestaurantRepository $categorieRestaurantRepository, FileUploader $fileUploader, EntityManagerInterface $em)
    {
        $this->categorieRestaurantRepository = $categorieRestaurantRepository;
        $this->fileUploader = $fileUploader;
        $this->entityManagerInterface = $em;
    }
    // fin constructeur de classe 

    
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
    public function new(Request $request): Response
    {
                // instanciation de classe - entité
        $categorieRestaurant = new CategorieRestaurant();
                // récupération du formulaire de création de nouveau produit
        $form = $this->createForm(CategorieRestaurantType::class, $categorieRestaurant);
                // traitement
        $form->handleRequest($request);
// condition si le formulaire soumis est valide
        if ($form->isSubmitted() && $form->isValid()) {
            /** 
             * @var UploadedFile $image 
             */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the image/photo field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $image = $this->fileUploader->upload($imageFile); // l'upload du fichier
                $categorieRestaurant->setImage($image);  // le nom du fichier 
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
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $image = $this->fileUploader->upload($imageFile); // l'upload du fichier
                $categorieRestaurant->setImage($image);  // le nom du fichier 
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
        if ($this->isCsrfTokenValid('delete'.$categorieRestaurant->getId(), $request->request->get('_token'))) {
            $this->categorieRestaurantRepository->remove($categorieRestaurant);
        }

        return $this->redirectToRoute('app_admin_categorie_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
