<?php

// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;

// auto-wiring
use App\Entity\Nutrition;
use App\Form\NutritionType;
use App\Repository\NutritionRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Controller d'accès privé ADMIN : catégorie Nutrition: regimes alimentaires des livres et restaurants du site
/**
 * @Route("/admin/nutrition")
 */
class AdminNutritionController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_nutrition_index", methods={"GET"})
     */
    public function index(NutritionRepository $nutritionRepository): Response
    {
        return $this->render('admin_nutrition/index.html.twig', [
            'nutrition' => $nutritionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_nutrition_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NutritionRepository $nutritionRepository, FileUploader $fileUploader): Response
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
                $image = $fileUploader->upload($imageFile); // l'upload du fichier
                $nutrition->setImage($image);  // le nom du fichier 
            }
            $nutritionRepository->add($nutrition);
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
