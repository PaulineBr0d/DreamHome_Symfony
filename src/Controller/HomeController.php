<?php 

namespace App\Controller;

use App\Repository\ListingRepository;
use App\Repository\PropertyTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
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
    
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
    $houseType = $this->propertyTypeRepository->findOneBy(['name' => 'Maison']);
    $apartmentType = $this->propertyTypeRepository->findOneBy(['name' => 'Appartement']);
    
    $houses = $this->listingRepository->findBy([
        'propertyType' => $houseType
    ], ['createdAt' => 'DESC'], 3);

    $apartments = $this->listingRepository->findBy([
        'propertyType' => $apartmentType
    ], ['createdAt' => 'DESC'], 3);

    $favoriteIds = $request->getSession()->get('favorites', []);

    return $this->render('index.html.twig', [
        'houses' => $houses,
        'apartments' => $apartments,
        'favoriteIds' => $favoriteIds,
    ]);
    }
}
