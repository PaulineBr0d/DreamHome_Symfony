<?php

namespace App\Controller\User;


use App\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ListingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_AGENT')]
#[Route('/agent', name: 'agent_')]
class AgentController extends AbstractController
{   
    #[Route('/', name: 'dashboard')]
    public function index(): Response {
        
        $user = $this->getUser();
        $listings = $user->getListings();

        return $this->render('agent/dashboard.html.twig',
        [
            'listings' => $listings
        ]);
    }


}