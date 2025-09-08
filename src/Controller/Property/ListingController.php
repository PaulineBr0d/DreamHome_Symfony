<?php

namespace App\Controller\Property;

use App\Service\PropertyProvider;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ListingController extends AbstractController
{
    private PropertyProvider $propertyProvider;

    public function __construct(PropertyProvider $propertyProvider)
    {
        $this->propertyProvider = $propertyProvider;

    }
    
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $allProperties = $this->propertyProvider->getAllProperties();
        $favoriteIds = $request->getSession()->get('favorites', []);
        //Filtre par type
        $type1Listings = array_filter($allProperties, fn($p) => $p['propertyTypeId'] === 1);
        $type2Listings = array_filter($allProperties, fn($p) => $p['propertyTypeId'] === 2);

        // Max 3 items pour la page d'accueil
        $type1Listings = array_slice($type1Listings, 0, 3);
        $type2Listings = array_slice($type2Listings, 0, 3);

        return $this->render('index.html.twig', [
            'type1Listings' => $type1Listings,
            'type2Listings' => $type2Listings,
            'favoriteIds' => $favoriteIds,
        ]);
    }

    #[Route('/house', name: 'house')]
    public function typeHouse(Request $request, PaginatorInterface $paginator): Response
    {
        $listings = $this->propertyProvider->getPropertiesByType(1);
        $favoriteIds = $request->getSession()->get('favorites', []);
        //Knp Paginator pour paginer un tableau
        $pagination = $paginator->paginate(
            $listings,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('property/house.html.twig', [
            'pagination' => $pagination,
            'favoriteIds' => $favoriteIds,
        ]);
    }

    #[Route('/apartment', name: 'apartment')]
    public function typeApartment(Request $request, PaginatorInterface $paginator): Response
    {
        $listings = $this->propertyProvider->getPropertiesByType(2);
          $favoriteIds = $request->getSession()->get('favorites', []);
        $pagination = $paginator->paginate(
            $listings,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('property/apartment.html.twig', [
            'pagination' => $pagination,
             'favoriteIds' => $favoriteIds,
        ]);
    }
    #[Route('/search', name: 'search')]
     public function search(): Response
    {
        
        return $this->render('property/search.html.twig');
    }

}
