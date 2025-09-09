<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ListingRepository;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private ListingRepository $listingRepository;

    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        // Exemple : récupérer les 3 dernières annonces
        $latestListings = $this->listingRepository->findBy([], ['createdAt' => 'DESC'], 3);

        $favoriteIds = $request->getSession()->get('favorites', []);

        return $this->render('index.html.twig', [
            'latestListings' => $latestListings,
            'favoriteIds' => $favoriteIds,
        ]);
    }
}
