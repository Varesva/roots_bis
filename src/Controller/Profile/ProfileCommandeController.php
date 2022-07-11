<?php

namespace App\Controller\Profile;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("profile/historique-de-commandes")
 */
class ProfileCommandeController extends AbstractController
{
    private $commandeRepository;
    private $security;
    private $ligneCommandeRepository;
    private $produitRepository;

    public function __construct(CommandeRepository $commandeRepository, Security $security, LigneCommandeRepository $ligneCommandeRepository, ProduitRepository $produitRepository)
    {
        $this->commandeRepository = $commandeRepository;
        $this->security = $security;
        $this->ligneCommandeRepository = $ligneCommandeRepository;
        $this->produitRepository = $produitRepository;
    }

    // TOUTES LES COMMANDES d'un USER
    /**
     * @Route("/", name="app_profile_user_commande", methods={"GET"})
     */
    public function userOrderHistory()
    {
        $userId = $this->security->getUser();

        $commandes = $this->commandeRepository->findAllOrdersByUser($userId);

        return $this->render('profile_commande/commande.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    // AFFICHER DETAILS LIGNES COMMANDES USER
    /**
     * @Route("/{id}/details-commande", name="app_commande_show", methods={"GET"})
     */
    public function show($id, Commande $commande ): Response
    {
        $userId = $this->security->getUser();
        
        $orderId = $commande->getId();

        $c = $this->commandeRepository->findOneOrder($userId, $orderId);

        $lignes = $this->ligneCommandeRepository->findLignesByOrder($orderId);

        // $c = $this->commandeRepository->find($orderId) ;

        // $orderId = $id;

        // $orderId = $commandes->commandes[0]->getId();  
        // $orderId = $commandes;  
        // $orderId = $commandes[0]->getId(); 
       
       
   
        return $this->render('profile_commande/show.html.twig', [
            'commande' => $c,
            'lignes_commande' => $lignes,
        ]);
    }
}
