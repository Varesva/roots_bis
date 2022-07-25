<?php

namespace App\Controller\Admin;

use App\Entity\Nutrition;
use App\Form\NutritionType;
use App\Service\FileUploader;
use App\Repository\NutritionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/nutrition")
 */
class AdminNutritionController extends AbstractController
{
    protected $nutritionRepository;
    protected $fileUploader;
    protected $em;

    public function __construct(NutritionRepository $nutritionRepository, FileUploader $fileUploader, EntityManagerInterface $em)
    {
        $this->nutritionRepository = $nutritionRepository;
        $this->fileUploader = $fileUploader;
        $this->entityManagerInterface = $em;
    }

    /**
     * @Route("/", name="app_admin_nutrition_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_nutrition/index.html.twig', [
            'nutrition' => $this->nutritionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_nutrition_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $nutrition = new Nutrition();
        $form = $this->createForm(NutritionType::class, $nutrition);
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
                $image = $this->fileUploader->upload($imageFile, $directory); // l'upload du fichier
                $nutrition->setImage($image);  // le nom du fichier 
            }
            $this->nutritionRepository->add($nutrition);
            return $this->redirectToRoute('app_admin_nutrition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_nutrition/new.html.twig', [
            'nutrition' => $nutrition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_nutrition_show", methods={"GET"})
     */
    public function show(Nutrition $nutrition): Response
    {
        return $this->render('admin_nutrition/show.html.twig', [
            'nutrition' => $nutrition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_nutrition_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Nutrition $nutrition, NutritionRepository $nutritionRepository): Response
    {
        $form = $this->createForm(NutritionType::class, $nutrition);
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
                $image = $this->fileUploader->upload($imageFile, $directory); // l'upload du fichier
                $nutrition->setImage($image);  // le nom du fichier 
            }
            $nutritionRepository->add($nutrition);
            return $this->redirectToRoute('app_admin_nutrition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_nutrition/edit.html.twig', [
            'nutrition' => $nutrition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_nutrition_delete", methods={"POST"})
     */
    public function delete(Request $request, Nutrition $nutrition, NutritionRepository $nutritionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nutrition->getId(), $request->request->get('_token'))) {
            $nutritionRepository->remove($nutrition);
        }

        return $this->redirectToRoute('app_admin_nutrition_index', [], Response::HTTP_SEE_OTHER);
    }
}
