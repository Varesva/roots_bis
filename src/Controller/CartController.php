<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    // Pour voir le panier
    /**
     * @Route("/cart", name="app_cart_index")
     */
    public function index(CartService $cartService)
    {
        // retourner la vue avec les données du panier et le total des prix
        return $this->render('cart/index.html.twig', [
            'ligne_panier' => $cartService->indexCart(), // appel de la fonction indexCart() de la classe CartService du service container
            'total_cart' => $cartService->totalCart()  // appel de la fonction totalCart() de la classe CartService du service container
        ]);
    }

    // création de panier et ajouter un article au panier--- le param converter recupere l'{id} dans l'url
    /**
     * @Route("/cart/add/{id}", name="app_cart_add")
     */
    public function add($id, CartService $cartService)
    {
        // appel de la fonction add de la classe CartService du service container 
        $cartService->add($id);
        // retourner la vue avec les données du panier et le total des prix
        return $this->redirectToRoute('app_cart_index');
    }

    // Supprimer un seul article du panier
    /**
     * @Route("/cart/remove/{id}", name="app_cart_remove")
     */
    public function remove($id, CartService $cartService)
    {
        // appel de la fonction remove de la classe CartService du service container 
        $cartService->remove($id);
        // redirige vers la vue
        return $this->redirectToRoute('app_cart_index');
    }


    // pour vider le panier
    /**
     * @Route("/cart/clear", name="app_cart_clear")
     */
    public function clear(CartService $cartService)
    {
        $cartService->clear();
        return $this->redirectToRoute('app_cart_index');
    }
}
