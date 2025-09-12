<?php
namespace App\Controller\API;

use App\Entity\TransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class ApiTransactionController extends AbstractController
{
    
#[Route('/api/transaction_types', name: 'create_transaction_type', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $transactionType = $serializer->deserialize(
            $request->getContent(),
            TransactionType::class,
            'json',
            ['groups' => ['transaction:write']]
        );

        $entityManager->persist($transactionType);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($transactionType, 'json', ['groups' => ['transaction:read']]),
            201,
            [],
            true 
        );
    }
}
