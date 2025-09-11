<?php

namespace App\Controller\User;


use App\Entity\User;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Repository\ListingRepository;
use App\Repository\UserRepository;
use App\Form\UserType;
use App\Form\PropertyTypeType;
use App\Form\TransactionTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{   
    #[Route('/', name: 'dashboard')]
    public function index(): Response {
        return $this->render('admin/dashboard.html.twig');
    }


    #[Route('/listings', name: 'listing_index')]
    public function listingIndex(ListingRepository $listingRepository): Response
    {
        $listings = $listingRepository->findAll(); // ou filtrer selon besoins

        return $this->render('admin/listing_index.html.twig', [
            'listings' => $listings
        ]);
    }

    #[Route('/users', name: 'user_index')]
    public function userIndex(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/user_index.html.twig', [
            'users' => $users
        ]);
    }
    #[Route('/users/edit/{id}', name: 'user_edit')]
    public function editUser(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        // Gestion du formulaire d'édition
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Utilisateur modifié.');
            return $this->redirectToRoute('admin_user_index');
        }
         // Gestion du bouton de suppression
        if ($request->request->has('delete') && $this->isCsrfTokenValid('delete_user' . $user->getId(), $request->request->get('_token'))) {
        if ($user === $this->getUser()) {
            $this->addFlash('warning', 'Vous ne pouvez pas vous supprimer vous-même.');
        } else {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur supprimé.');
        }
        return $this->redirectToRoute('admin_user_index');
    }

        return $this->render('admin/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
    



    #[Route('/property-type/add', name: 'property_type_add')]
    public function addPropertyType(Request $request, EntityManagerInterface $em)
    {
        $propertyType = new PropertyType();
    

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
