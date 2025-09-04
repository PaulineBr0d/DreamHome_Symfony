<?php 

namespace App\Controller\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ApartmentController extends AbstractController
{
    #[Route('/apartment', name: 'apartment')]
    public function index(): response
    {
         return $this->render('property/apartment.html.twig'); 
    }
}