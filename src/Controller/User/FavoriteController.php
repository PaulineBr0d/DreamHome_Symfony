<?php 

namespace App\Controller\User;

use App\Entity\Listing;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FavoriteController extends AbstractController
{

    #[Route('/favorite', name: 'favorite')]
    public function favoriteList(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté.');
            return $this->redirectToRoute('home');
        }

        $favorites = $user->getFavorites();

        return $this->render('user/favorite.html.twig', [
            'favorites' => $favorites,
             'userId' => $user->getId(),
        ]);
    }

    #[Route('/favorite/toggle/{id}', name: 'favorite_toggle', methods: ['POST'])]
    public function toggleFavorite(
        int $id,
        ListingRepository $listingRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): RedirectResponse {
        $user = $this->getUser();

    if (!$user) {
        $this->addFlash('error', 'Vous devez être connecté pour gérer vos favoris.');
        return $this->redirectToRoute('app_login');
    }

    $listing = $listingRepository->find($id);

    if (!$listing) {
        $this->addFlash('error', 'Annonce introuvable.');
        return $this->redirectToRoute('home');
    }

    if ($user->getFavorites()->contains($listing)) {
        $user->removeFavorite($listing);
        $this->addFlash('success', 'Annonce retirée des favoris.');
    } else {
        $user->addFavorite($listing);
        $this->addFlash('success', 'Annonce ajoutée aux favoris.');
    }

    $entityManager->flush();

    //Ramener l’utilisateur à la page d’où il vient ou à l'index
    $referer = $request->headers->get('referer');
    return new RedirectResponse($referer ?: $this->generateUrl('home'));
        
}
}