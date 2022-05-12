<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\NutritionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRestaurantRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public, reprend les infos du Ctrl adminProduit  : produits de la boutique, leurs propriétés et catégories
/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    // constructeur de classe  - pour tjrs avoir ces variables avec la classe
    protected $produitRepository;
    protected $em;

    public function __construct(ProduitRepository  $produitRepository, EntityManagerInterface $em)
    {
        $this->produitRepository = $produitRepository;
        $this->entityManagerInterface = $em;
    }
    // fin constructeur de classe  

    // afficher tous les produits
    /**
     * @Route("/", name="app_produit_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $this->produitRepository->findAll(),
        ]);
    }

    // afficher un seul produit selon son id
    /**
     * @Route("/{id}", name="app_produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    // afficher un seul produit à partir du PANIER selon son id
    /**
     * @Route("/{id}", name="app_produit_cart_show", methods={"GET"})
     */
    public function cartShow(Produit $produit): Response
    {
        return $this->render('produit/cart_show.html.twig', [
            'produit' => $produit,
        ]);
    }

    // afficher toutes les cartes cadeaux
    /**
     * @Route("/cartes-cadeaux/{id}", name="app_produit_giftcard", methods={"GET"})
     */
    public function showByGiftcard($id): Response
    {
        // récuperer tous les produits de la categorie séléctionnée
        $produits = $this->produitRepository->findBy(
            ['categ_produit' => $id]
        );
        // retourner la vue
        return $this->render('produit/giftcard.html.twig', [
            'produits' => $produits,
        ]);
    }
    // afficher tous les livres
    /**
     * @Route("/livres-de-recettes/{id}", name="app_produit_livre", methods={"GET"})
     */
    public function showByLivre($id): Response
    {
        // récuperer tous les produits de la categorie séléctionnée
        $livres = $this->produitRepository->findBy(
            ['categ_produit' => $id]
        );
        // retourner la vue
        return $this->render('produit/livre.html.twig', [
            'produits' => $livres,
        ]);
    }

    // afficher tous les livres selon le type de cuisine
    /**
     * @Route("/types-de-cuisines/{id}", name="app_produit_ByCateg_cuisine", methods={"GET"})
     */
    public function showByLivreCuisine($id, CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        // récuperer tous les produits de la categorie séléctionnée
        $produitRepository = $this->produitRepository->findBy(
            ['categ_type_cuisine' => $id]
        );
        
        // retourner la vue
        if ($id == 1) {
            return $this->render('produit/livreafri.html.twig', [
                'produits' => $produitRepository,
            ]);
        } elseif ($id == 2) {
            // retourner la vue
            return $this->render('produit/livrecarib.html.twig', [
                'produits' => $produitRepository,
            ]);
        } else {
            return $this->render('produit/categorie.html.twig', [
                'categorie_restaurants' => $categorieRestaurantRepository->findAll(),
            ]);
        }
    }

    // afficher tous les livres selon régime alimentaire
    /**
     * @Route("/types-alimentations/{id}", name="app_produit_ByCateg_nutrition", methods={"GET"})
     */ 

    public function showByLivreNutrition($id, RestaurantRepository $restaurantRepository): Response
    {
        // récuperer tous les produits de la categorie séléctionnée
        $produitRepository = $this->produitRepository->findBy(
            ['categ_nutrition' => $id]
        );
        $restaurantRepository = $restaurantRepository ->findBy(
            ['nutrition' => $id]
        );
        
        // retourner la vue
            return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository,
            'restaurants' => $restaurantRepository,
            ]);
    }
}
