<?php 

namespace App\Controller\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AddController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function index(): response
    {
         return $this->render('property/add.html.twig'); 
    }
}