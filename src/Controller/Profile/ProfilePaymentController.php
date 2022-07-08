<?php

namespace App\Controller\Profile;

use Stripe\Stripe;
use App\Entity\User;
use App\Form\UserType;
use Stripe\PaymentIntent;
use App\Service\Cart\CartService;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Service\Payment\PaymentService;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Service\BillingPortal\SessionService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/profile/paiement")
 */
class ProfilePaymentController extends AbstractController
{
    // CONSTRUCTEUR DE CLASSE 
    private $security;
    private $cartService;
    private $session;
    private $paymentService;

    public function __construct(PaymentService $paymentService, Security $security, CartService $cartService, SessionInterface $session, UserRepository $userRepository, CommandeRepository $commandeRepository)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->session = $session;
        $this->paymentService = $paymentService;
        $this->userRepository = $userRepository;
        $this->commandeRepository = $commandeRepository;
    }

    // afficher la page de paiement avec toutes les infos
    /**
     * @Route("", name="app_profile_payment")
     */
    public function createPayment(): Response
    {
        $this->security->getUser();

        // récupérer la valeur de la variable avec prix et devise monétaire
        $paymentIntent = $this->paymentService->paymentIntent();
        // récuperer le prix total ttc du panier
        $total_ttc = $this->cartService->calculTTC();

        // $user_order_detail = $this->UserAddress($user, $request);

        // renvoyer la vue
        return $this->render('profile_payment/index.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,
            'total_ttc' => $total_ttc,
            // 'user_order_detail' => $user_order_detail
        ]);
    }

    // afficher la confirmation d'adresse de livraison
    /**
     * @Route("/adresse-livraison", name="app_profile_payment_userAddress", methods={"GET", "POST"})
     */
    // public function UserAddress(User $user, Request $request)
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //     // récupérer prix et devise monétaire
    //     $paymentIntent = $this->paymentService->paymentIntent();
    //     // récuperer prix total ttc du panier
    //     $total_ttc = $this->cartService->calculTTC();


    //     // création du formulaire adresse paiement 
    //     $user_address_form = $this->createForm(UserType::class, $user);

    //     $livraison_form = $this->createForm(AdresseLivraisonType::class, $user);

    //     // retirer des champs
    //     // $user_address_form = $form->get('form');
    //     $user_address_form ->remove('email');
    //     $user_address_form ->remove('roles');
    //     $user_address_form ->remove('password');
    //     $user_address_form ->remove('isVerified');
    //     // traitement formulaire
    //     $user_address_form->handleRequest($request);

    //     // condition if
    //     if ($user_address_form->isSubmitted() && $user_address_form->isValid()) {
    //         // ajout et modification du repository
    //         $this->userRepository->add($user);
    //         // rediriger vers la vue
    //         return $this->redirectToRoute('app_profile_payment', [
    //             'clientSecret' => $paymentIntent->client_secret,
    //             'total_ttc' => $total_ttc,
    //         ], Response::HTTP_SEE_OTHER);
    //     }
    //     // renvoyer la vue
    //     return $this->renderForm('profile_payment/userAddress.html.twig', [
    //         'user' => $user,
    //         'user_address_form' => $user_address_form,
    //     ]);
    // }



    // public function UserAddress(User $user, Request $request)
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //     // récupérer la valeur de la variable avec prix et devise monétaire
    //     $paymentIntent = $this->paymentService->paymentIntent();
    //     // récuperer le prix total ttc du panier
    //     $total_ttc = $this->cartService->calculTTC();


    //     // création du formulaire adresse paiement 
    //     $user_address_form = $this->createForm(UserType::class, $user);
    //     // retirer des champs
    //     // $user_address_form = $form->get('form');
    //     $user_address_form ->remove('email');
    //     $user_address_form ->remove('roles');
    //     $user_address_form ->remove('password');
    //     $user_address_form ->remove('isVerified');
    //     // traitement formulaire
    //     $user_address_form->handleRequest($request);

    //     // condition if
    //     if ($user_address_form->isSubmitted() && $user_address_form->isValid()) {
    //         // ajout et modification du repository
    //         $this->userRepository->add($user);
    //         // rediriger vers la vue
    //         return $this->redirectToRoute('app_profile_payment', [
    //             'clientSecret' => $paymentIntent->client_secret,
    //             'total_ttc' => $total_ttc,
    //         ], Response::HTTP_SEE_OTHER);
    //     }
    //     // renvoyer la vue
    //     return $this->renderForm('profile_payment/userAddress.html.twig', [
    //         'user' => $user,
    //         'user_address_form' => $user_address_form,
    //     ]);
    // }

    // afficher la page de confirmation de paiement 
    /**
     * @Route("/confirmation", name="app_profile_payment_valid")
     */
    // public function confirmation(): Response
    // {
    //     return $this->render('profile_payment/confirm.html.twig', []);
    // }

    /**
     * @Route("/confirm", name="app_profile_payment_confirm")
     */
    public function confirm(): Response
    {
        // RECUP PRIX ET DEVISE MONETAIRE
        $paymentIntent = $this->paymentService->paymentIntent();

        // RECUP TOTAL TTC PANIER
        $total_ttc = $this->cartService->calculTTC();

        // RECUP PANIER ENTIEREMENT(prix, produits, quantité)
        $cartService = $this->cartService->indexCart();

        // NUM REF COMMANDE
        $orderRefNumber = $this->commandeRepository->findLastOrderRef();

        $refNumber = $orderRefNumber[0]->getReference();

        // AJOUT EN BDD
        $this->paymentService->confirmOrderDB();

        // $orderRefNumber = $this->paymentService->confirmOrderDB();


        // VIDER LE PANIER APRES PAIEMENT
        $this->cartService->clear();

        // retourner la vue de confirmation
        // return $this->redirectToRoute('app_profile_payment_valid');

        return $this->render('profile_payment/confirm.html.twig', [
            'orderRef' =>
            $refNumber,
        ]);
    }
}
