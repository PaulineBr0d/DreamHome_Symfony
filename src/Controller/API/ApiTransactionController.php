<?php
namespace App\Controller\API;

use App\Entity\TransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiTransactionController extends AbstractController
{
    #[Route('/api/transaction_types', name: 'create_transaction_type', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || empty($data['name'])) {
            return new JsonResponse(['error' => 'Le champ "name" est requis.'], 400);
        }

        $transactionType = new TransactionType();
        $transactionType->setName($data['name']);


        $entityManager->persist($transactionType);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $transactionType->getId(),
            'name' => $transactionType->getName()
        ], 201);
    }
}
