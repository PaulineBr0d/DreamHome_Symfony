<?php 

namespace App\Controller\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HouseController extends AbstractController
{
    #[Route('/house', name: 'house')]
    public function index(): response
    {
         return $this->render('property/house.html.twig'); 
    }
}