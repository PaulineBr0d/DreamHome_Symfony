<?php

namespace App\Controller\API;

use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/listing', name: 'api_listing_')]
class ApiListingController extends AbstractController
{
    private ListingRepository $listingRepository;

    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    #[Route(path: '', name: 'list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $listings = $this->listingRepository->findBy([], ['createdAt' => 'DESC'], 10);
        //$listings = $this->listingRepository->findAll();
       
        return $this->json($listings, 200, [], ['groups' => ['listing:read','timestampable:read','transaction:read']]);
    }
}