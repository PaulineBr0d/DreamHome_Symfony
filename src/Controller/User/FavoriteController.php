<?php 

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'favorite')]
    public function index(): Response
    {
        $user = $this->getUser();

        // Simuler des favoris
        $favorites = [
            [
                'ID' => 1,
                'title' => 'Maison avec piscine',
                'img' => '/uploads/properties/maison1.webp',
                'propertyTypeId' => 'Maison',
                'price' => 450000,
                'city' => 'Montpellier',
                'description' => 'Maison 3 chambres, jardin, piscine et terrasse.',
                'transaction' => 'Vente',
                'userId' => $user ? $user->getId() : null,
            ],
            // autres favoris...
        ];

        return $this->render('user/favorite.html.twig', [
            'favorites' => $favorites,
            'userId' => $user ? $user->getId() : null,
            'userRole' => $user ? $user->getRoles() : [],
        ]);
    }
}