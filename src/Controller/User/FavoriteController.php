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
        ]);
    }


}