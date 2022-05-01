<?php
// dossier virtuel pouraccéder au dossier de ce fichier
namespace App\Controller;
// auto-wiring
use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/panier")
 */

// Controller d'accès public, hors bdd : Panier du site Roots
class CartController extends AbstractController
{
    // Pour voir le panier
    /**
     * @Route("/", name="app_cart_index")
     */
    public function indexCart(CartService $cartService)
    {
        $full_cart = $cartService->indexCart();
        $total_cart_ht = $cartService->totalCart();
        $total_ttc = $cartService->calculTTC();

        // retourner la vue avec les données du panier et le total des prix
        return $this->render('cart/index.html.twig', [
            'ligne_panier' => $full_cart,
            'total_cart_ht' => $total_cart_ht,
            'total_ttc' => $total_ttc,
        ]);
    }

    // création de panier et ajouter un article au panier--- le param converter recupere l'{id} dans l'url
    /**
     * @Route("/ajouter/{id}", name="app_cart_add")
     */
    public function plusOne($id, CartService $cartService)
    {
        // appel de la fonction add de la classe CartService du service container 
        $cartService->plusOne($id);             
      
        // retourner la vue avec les données du panier 
        return $this->redirectToRoute('app_cart_index');
    }
    /**
     * @Route("/retirer/{id}", name="app_cart_remove")
     */
    public function minusOne($id, CartService $cartService)
    {
        // appel de la fonction minusOne de la classe CartService du service container 
        $cartService->minusOne($id);
        // retourner la vue avec les données du panier 
        return $this->redirectToRoute('app_cart_index');
    }

    // Supprimer un seul article du panier
    /**
     * @Route("/supprimer/{id}", name="app_cart_delete")
     */
    public function delete($id, CartService $cartService)
    {
        // appel de la fonction delete de la classe CartService du service container 
        $cartService->delete($id);
        // redirige vers la vue
        return $this->redirectToRoute('app_cart_index');
    }


    // pour vider le panier
    /**
     * @Route("/panier/vider", name="app_cart_clear")
     */
    public function clear(CartService $cartService)
    {
        $cartService->clear();
        return $this->redirectToRoute('app_cart_index');
    }
}
