<?php

namespace App\Controller\User;


use App\Entity\User;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Repository\ListingRepository;
use App\Repository\PropertyTypeRepository;
use App\Repository\TransactionTypeRepository;
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
        $listings = $listingRepository->findAll(); 

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
    
    #[Route('/types/{typeName}', name: 'types')]
    public function dashboard(
        string $typeName, 
        PropertyTypeRepository $propertyRepo, 
        TransactionTypeRepository $transactionRepo
    ): Response {
        if ($typeName === 'property') {
            $types = $propertyRepo->findAll();
            $title = 'Types de propriété';
        } elseif ($typeName === 'transaction') {
            $types = $transactionRepo->findAll();
            $title = 'Types de transaction'; 
        } else {
            throw $this->createNotFoundException('Type inconnu');
        }

        return $this->render('admin/type_index.html.twig', [
            'types' => $types,
            'typeName' => $typeName,
            'title' => $title,
        ]);
    }

    #[Route('/types/{typeName}/add', name: 'types_add')]
    public function add(
        string $typeName,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($typeName === 'property') {
            $type = new PropertyType();
            $title = 'Ajouter un type de propriété';
            $formTypeClass = PropertyTypeType::class;
        } elseif ($typeName === 'transaction') {
            $type = new TransactionType();
            $title = 'Ajouter un type de transaction';
            $formTypeClass = TransactionTypeType::class;
        } else {
            throw $this->createNotFoundException('Type inconnu');
        }

        $form = $this->createForm($formTypeClass, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type);
            $em->flush();

            $this->addFlash('success', 'Type ajouté avec succès.');
            return $this->redirectToRoute('admin_types', ['typeName' => $typeName]);
        }

        return $this->render('admin/type_form.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
            'typeName' => $typeName,
        ]);
    }

}
