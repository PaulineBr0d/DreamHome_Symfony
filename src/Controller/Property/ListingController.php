<?php

namespace App\Controller\Property;

use App\Repository\ListingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    private ListingRepository $listingRepository;

    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    #[Route('/listing/house', name: 'listing_house')]
    public function typeHouse(Request $request, PaginatorInterface $paginator): Response
    {
        $listings = $this->listingRepository->findBy(['propertyType' => 1]);

        $pagination = $paginator->paginate(
            $listings,
            $request->query->getInt('page', 1),
            10
        );

        $favoriteIds = $request->getSession()->get('favorites', []);

        return $this->render('property/house.html.twig', [
            'pagination' => $pagination,
            'favoriteIds' => $favoriteIds,
        ]);
    }

    #[Route('/listing/apartment', name: 'listing_apartment')]
    public function typeApartment(Request $request, PaginatorInterface $paginator): Response
    {
        $listings = $this->listingRepository->findBy(['propertyType' => 2]);

        $pagination = $paginator->paginate(
            $listings,
            $request->query->getInt('page', 1),
            10
        );

        $favoriteIds = $request->getSession()->get('favorites', []);

        return $this->render('property/apartment.html.twig', [
            'pagination' => $pagination,
            'favoriteIds' => $favoriteIds,
        ]);
    }

    #[Route('/listing/{id}', name: 'listing_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $listing = $this->listingRepository->find($id);

        if (!$listing) {
            throw $this->createNotFoundException('Annonce introuvable.');
        }

        $favoriteIds = $this->get('session')->get('favorites', []);

        return $this->render('property/show.html.twig', [
            'listing' => $listing,
            'favoriteIds' => $favoriteIds,
        ]);
    }

    #[Route('/listing/search', name: 'listing_search')]
    public function search(Request $request): Response
    {
        $city = $request->query->get('city');
        $type = $request->query->get('property_type');
        $transaction = $request->query->get('transaction_type');
        $maxPrice = $request->query->get('max_price');

        $results = $this->listingRepository->search($city, $type, $transaction, $maxPrice);

        $favoriteIds = $request->getSession()->get('favorites', []);

        return $this->render('property/search.html.twig', [
            'listings' => $results,
            'favoriteIds' => $favoriteIds,
        ]);
    }
}
