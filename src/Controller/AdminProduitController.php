<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Service\FileUploader;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès privé ADMIN : produits de la boutique, leurs propriétés et catégories
/**
 * @Route("/admin/produit")
 */
class AdminProduitController extends AbstractController
{
    // constructeur de classe  - pour tjrs avoir ces variables avec la classe
    protected $produitRepository;
    protected $fileUploader;
    protected $em;

    public function __construct(ProduitRepository $produitRepository, FileUploader $fileUploader, EntityManagerInterface $em)
    {
        $this->produitRepository = $produitRepository;
        $this->fileUploader = $fileUploader;
        $this->entityManagerInterface = $em;
    }
    // fin constructeur de classe  

    // afficher tous les produits
    /**
     * @Route("/", name="app_admin_produit_index", methods={"GET"})
     */
    public function index(): Response
    {
        // récuperer tous les produits
        $produitRepository = $this->produitRepository->findAll();
        // retourner la vue
        return $this->render('admin_produit/index.html.twig', [
            'produits' => $produitRepository,
        ]);
    }

    // afficher toutes les cartes cadeaux de la catégorie adminboutique
    /**
     * @Route("/voir/{id}", name="app_admin_produit_byCateg", methods={"GET"})
     */
    public function showByCateg($id): Response
    {
        // récuperer tous les produits
        $produitRepository = $this->produitRepository->findBy(
            ['categ_produit' => $id]
        );
        // retourner la vue
        return $this->render('admin_produit/index.html.twig', [
            'produits' => $produitRepository,
        ]);
    }
 
    /**
     * @Route("/new", name="app_admin_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        // instanciation de classe - entité Produit
        $produit =  new Produit();
        // récupération du formulaire de création de nouveau produit
        $form = $this->createForm(ProduitType::class, $produit);
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
                $produit->setImage($image);  // le nom du fichier 
            }

            $this->produitRepository->add($produit);

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('admin_produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** 
             * @var UploadedFile $image 
             */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $image = $this->fileUploader->upload($imageFile); // l'upload du fichier
                $produit->setImage($image);  // le nom du fichier 
            }

            $this->produitRepository->add($produit);
            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit);
        }

        return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
    }

}
