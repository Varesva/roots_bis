<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Form\SearchNavbarType;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    private $rp;

    public function __construct(RestaurantRepository $rp)
    {
        $this->rp = $rp;
    }

    // FORM SEARCHTYPE 
    public function searchBar()
    {
        $searchForm = $this->createForm(SearchType::class);

        // $searchForm = $this->createForm(SearchType::class, [
        //     'action' => $this->generateUrl('rechercher'),
        //     // 'method' => 'GET',
        // ]);

        
        return $this->renderForm('search/_form.html.twig', [
            'searchForm' => $searchForm,
        ]);
    }

    // FORM NAVBAR BURGER SEARCHTYPE 
    public function navbarSearchBar()
    {
        $navbarSearchForm = $this->createForm(SearchNavbarType::class);

        return $this->renderForm('search/_form_navbar_search.html.twig', [
            'navbarSearchForm' => $navbarSearchForm,
        ]);
    }

    /**
     * @Route("/rechercher", name="rechercher")
     */
    public function rechercher(Request $request): Response
    {
        $navbarSearchForm = $this->createForm(SearchNavbarType::class);

        $searchForm = $this->createForm(SearchType::class);


        $searchForm->handleRequest($request);

        // RECHERCHE LOCALISATION
        $qL = $searchForm->get('queryLocation')->getData();

        // RECHERCHE NOM, SPECIALITE, NUTRITION, (CATEGORIE):pas sure
        $q = $searchForm->get('query')->getData();

        if ($qL || $q ) {
    
            if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // if ($qL || $q) {
                // $queries = [
                    $location = $this->rp->findByLocation($qL);
                    
                    $query = $this->rp->findByQuery($q);
                // ];
// dd($queries);
                return $this->render('search/result.html.twig', [
                    'location' => $location,
                    'query' => $query,
                ]);
            }
        }
        elseif ($searchForm->isSubmitted() && $searchForm->isValid() && empty($qL) || empty($q) ) {

            $this->addFlash('error', 'Votre recherche ne peut pas être vide');
            
            return $this->renderForm('search/index.html.twig', [
                'searchForm' => $searchForm,
                'navbarSearchForm' => $navbarSearchForm,

            ]);
        
        } else {

            return $this->renderForm('search/index.html.twig', [
                'searchForm' => $searchForm,
                'navbarSearchForm' => $navbarSearchForm,

            ]);
        }
    }
}
