<?php

namespace App\Controller\Property;

use App\Repository\ListingRepository;
use App\Repository\PropertyTypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    private ListingRepository $listingRepository;
    private PropertyTypeRepository $propertyTypeRepository;

    public function __construct(  
        ListingRepository $listingRepository,
        PropertyTypeRepository $propertyTypeRepository)
    {
        $this->listingRepository = $listingRepository;
        $this->propertyTypeRepository = $propertyTypeRepository;
    }

    #[Route('/listing/type/{name}', name: 'listing_by_type')]
    public function listingsByType(
        string $name,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
    $type = $this->propertyTypeRepository->findOneBy(['name' => $name]);

    if (!$type) {
        throw $this->createNotFoundException('Type de bien introuvable.');
    }

    $listings = $this->listingRepository->findBy(['propertyType' => $type]);

    $pagination = $paginator->paginate($listings, $request->query->getInt('page', 1), 10);
    $favoriteIds = $request->getSession()->get('favorites', []);

    return $this->render('property/list_by_type.html.twig', [
        'pagination' => $pagination,
        'favoriteIds' => $favoriteIds,
        'type' => $name
    ]);
}

    #[Route('/listing/{id}', name: 'listing_show', requirements: ['id' => '\d+'])]
    public function show(int $id, Request $request): Response
    {
        $listing = $this->listingRepository->find($id);

        if (!$listing) {
            throw $this->createNotFoundException('Annonce introuvable.');
        }

        $favoriteIds = $request->getSession()->get('favorites', []);

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
