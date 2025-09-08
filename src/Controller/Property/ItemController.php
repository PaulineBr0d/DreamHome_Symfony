<?php 

namespace App\Controller\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(): response
    {
         return $this->render('property/add.html.twig'); 
    }

    #[Route('/update', name: 'update')]
    public function update(): response
    {
         return $this->render('property/update.html.twig'); 
    }
}