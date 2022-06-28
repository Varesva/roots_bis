<?php
namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/panier")
 */

class CartController extends AbstractController
{
    // constructeur
    // récup le service du panier
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // voir le panier
    /**
     * @Route("/", name="app_cart_index")
     */
    public function indexCart()
    {
        $full_cart = $this->cartService->indexCart();
        $total_cart_ht = $this->cartService->totalCart();
        $total_ttc = $this->cartService->calculTTC();

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
    public function plusOne($id)
    {
        // appel de la fonction plusOne ajouter un produit au panier, contenue dans la classe CartService du service container 
        $this->cartService->plusOne($id);             
      
        // retourner la vue avec les données du panier 
        return $this->redirectToRoute('app_cart_index');
    }
    // retirer un article du panier
    /**
     * @Route("/retirer/{id}", name="app_cart_remove")
     */
    public function minusOne($id)
    {
        // appel de la fonction minusOne de la classe CartService du service container 
        $this->cartService->minusOne($id);
        // retourner la vue avec les données du panier 
        return $this->redirectToRoute('app_cart_index');
    }

    // Supprimer un seul article du panier
    /**
     * @Route("/supprimer/{id}", name="app_cart_delete")
     */
    public function delete($id)
    {
        // appel de la fonction delete de la classe CartService du service container 
        $this->cartService->delete($id);
        // redirige vers la vue
        return $this->redirectToRoute('app_cart_index');
    }

    // pour vider le panier
    /**
     * @Route("/vider", name="app_cart_clear")
     */
    public function clear()
    {
        $this->cartService->clear();
        return $this->redirectToRoute('app_cart_index');
    }
}
