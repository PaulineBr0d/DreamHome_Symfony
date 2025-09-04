<?php 

namespace App\Controller\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function index(): response
    {
         return $this->render('property/search.html.twig'); 
    }
}