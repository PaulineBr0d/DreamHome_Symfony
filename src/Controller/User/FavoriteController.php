<?php 

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'favorite')]
    public function index(): response
    {
         return $this->render('user/favorite.html.twig'); 
    }
}