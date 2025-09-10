<?php

namespace App\Controller;

use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Form\PropertyTypeType;
use App\Form\TransactionTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{       
    #[Route('/property-type/add', name: 'property_type_add')]
    public function addPropertyType(Request $request, EntityManagerInterface $em)
    {
        $propertyType = new PropertyType();
        $now = new \DateTimeImmutable();
        $propertyType->setCreatedAt($now);
        $propertyType->setUpdatedAt($now);

        $form = $this->createForm(PropertyTypeType::class, $propertyType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($propertyType);
            $em->flush();

            $this->addFlash('success', 'Type de propriété ajouté.');
            return $this->redirectToRoute('admin_property_type_add');
        }

        return $this->render('admin/type_form.html.twig', [
            'form' => $form,
            'title' => 'Ajouter un type de propriété',
        ]);
    }

    #[Route('/transaction-type/add', name: 'transaction_type_add')]
    public function addTransactionType(Request $request, EntityManagerInterface $em)
    {
        $transactionType = new TransactionType();

        $now = new \DateTimeImmutable();
        $transactionType->setCreatedAt($now);
        $transactionType->setUpdatedAt($now);

        $form = $this->createForm(TransactionTypeType::class, $transactionType);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($transactionType);
            $em->flush();

            $this->addFlash('success', 'Type de transaction ajouté.');
            return $this->redirectToRoute('admin_transaction_type_add');
        }

        return $this->render('admin/type_form.html.twig', [
            'form' => $form,
            'title' => 'Ajouter un type de transaction',
        ]);
    }
}
