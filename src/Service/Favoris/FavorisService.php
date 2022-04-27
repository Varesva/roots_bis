<?php
// dossier virtuel pouraccéder au dossier de ce fichier
// namespace App\Service\Favoris;
// auto-wiring
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class favorisService
{
    // constructeur de classe Favoris - pour tjrs avoir ces variables avec la classe
    protected $session;
    protected $produitRepository;

    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }
    // fin constructeur de classe Favoris

    // Pour voir les favoris dans son intégralité: avec les données des produits ajoutés dedans
    public function indexFav()
    {
        // pour crééer le favoris si la session (tableau) est inexistante ou l'actualiser si déjà créée
        $favorisService = $this->session->get('favoris', []);

        if (!empty($favorisService)) {
            foreach ($favorisService as $all_fav) {

            }
                            
            return $all_fav;
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('favoris', $favorisService);
    }

    // ajouter un article au favoris--- le param converter recupere l'{id} dans l'url
    public function addFav(int $id)
    {
        // pour crééer le favoris si la session est inexistante ou l'actualiser si la session est déjà créée
        $favorisService = $this->session->get('favoris', []);

        if (!empty($favorisService[$id])) // si tableau de favoris est not empty
        {
            $favorisService[$id] = $favorisService[$id] + 1; // increment: ajouter 1 au nombre de produit de l'id correspondant
        } else {
            // ajouter dans le tableau favoris l'id produit et la quantité = à 1
            $favorisService[$id] = 1;
        }
        // puis enregistrer l'ajout effectué du produit dans les favoris
        $this->session->set('favoris', $favorisService);
    }

    // retirer un article des favoris--- le param converter recupere l'{id} dans l'url
    public function removeFav(int $id)
    {
        // pour crééer le favoris si la session est inexistante ou l'actualiser si déjà créée
        $favorisService = $this->session->get('favoris', []);

        if (!empty($favorisService[$id])) // si le tableau de favoris est not empty
        {
            unset($favorisService[$id]);
            //    echo "Voulez-vous supprimer ce produit de vos favoris ?"; 
        }
        // puis enregistrer l'ajout effectué du produit 
        $this->session->set('favoris', $favorisService);
    }

    // pour vider entièrement les favoris
    public function clearFav()
    {
        $this->session->clear('favoris');
    }
}