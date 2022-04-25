<?php
// dossier virtuel pour accéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Controller d'accès public, reprend les infos du Ctrl adminProduit  : produits de la boutique, leurs propriétés et catégories
/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    // afficher tous les produits
    /**
     * @Route("/", name="app_produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
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

    // /**
    //  * @Route("/cartes-cadeaux/{id}", name="app_admin_prod_cat", methods={"GET"})
    //  */
    // public function showGiftcard(ProduitRepository $produitRepository, Produit $produit): Response
    // {
    //     return $this->render('produit/index.html.twig', [
    //         'produits' => $produitRepository->findBy(['categ_produit' => $produit->getCategProduit()]),
    //     ]);
    // }
}
