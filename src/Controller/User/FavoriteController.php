<?php 

namespace App\Controller\User;

use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'favorite')]
    public function index(Request $request, ListingRepository $repo): Response
    {
        $user = $this->getUser();
        $session = $request->getSession();
        $favoriteIds = $session->get('favorites', []);

        $favorites = [];

        foreach ($favoriteIds as $id) {
            $property = $repo->find($id);
            if ($property) {
                $favorites[] = $property;
            }
        }

        return $this->render('user/favorite.html.twig', [
            'favorites' => $favorites,
            'userId' => $user ? $user->getId() : null,
            'userRole' => $user ? $user->getRoles() : [],
        ]);
    }

    #[Route('/favorite', name: 'favorite_add', methods: ['POST'])]
    public function favorite(Request $request, ListingRepository $repo): Response
    {
        $id = (int)$request->request->get('id');
        $session = $request->getSession();

        if (!$this->getUser()) {
            $this->addFlash('error', 'Vous devez être connecté.');
            return $this->redirectToRoute('home');
        }

        // Simuler les favoris via la session
        $favorites = $session->get('favorites', []);

        if (in_array($id, $favorites)) {
            // Supprimer des favoris
            $favorites = array_filter($favorites, fn($favId) => $favId !== $id);
            $this->addFlash('info', 'Annonce retirée des favoris.');
        } else {
            // Ajouter aux favoris
            $favorites[] = $id;
            $this->addFlash('success', 'Annonce ajoutée aux favoris.');
        }

    $session->set('favorites', $favorites);

    return $this->redirectToRoute('home');
}

}