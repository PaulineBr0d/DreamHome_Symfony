<?php 

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function index(): response
    {
         return $this->render('user/register.html.twig'); 
    }
}