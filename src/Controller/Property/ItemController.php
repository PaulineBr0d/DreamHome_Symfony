<?php 
namespace App\Controller\Property;

use App\Form\ListingType;
use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Repository\UserRepository;
use App\Repository\ListingRepository;
use App\Repository\PropertyTypeRepository;
use App\Repository\TransactionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ItemController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        SluggerInterface $slugger
    ): Response {
        $listing = new Listing();

         // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour créer une annonce.');
        }
        $listing->setUser($user);
        
        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('uploadedFile')->getData();

        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('uploads_directory'), 
                    $newFilename
                );
            } catch (FileException $e) {
                // gestion de l'erreur
            }

            $listing->setImageUrl($newFilename); 
            }

            $em->persist($listing);
            $em->flush();

            $this->addFlash('success', 'Annonce ajoutée avec succès !');
            return $this->redirectToRoute('listing_show', ['id' => $listing->getId()]);
        }

        return $this->render('property/add.html.twig', [
            'form' => $form,
        ]);
        }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'])]
    public function update(
        #[MapEntity(id: 'id')] Listing $item,
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        // Vérifier que l'utilisateur est propriétaire ou admin
        if ($this->getUser() !== $item->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Vous n\'avez pas les droits pour modifier cette annonce.');
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(ListingType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('uploadedFile')->getData();

        if ($imageFile) {
          
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                 // gestion de l'erreur
            }
            $oldImage = $item->getImageUrl();

            if ($oldImage && file_exists($this->getParameter('uploads_directory').'/'.$oldImage)) {
                unlink($this->getParameter('uploads_directory').'/'.$oldImage);
            }
            $item->setImageUrl($newFilename);
        }

            $em->flush();

            $this->addFlash('success', 'Annonce mise à jour.');
            if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_listing_index');
        } else {
            return $this->redirectToRoute('listing_show', ['id' => $item->getId()]);
        }
        }   

        return $this->render('property/update.html.twig', [
            'form' => $form,
            'item' => $item, 
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(
        #[MapEntity(id: 'id')] Listing $item,  
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $item->getId(), $token)) {
            if ($this->getUser() === $item->getUser() || $this->isGranted('ROLE_ADMIN')) {
                $imageName = $item->getImageUrl(); // ou getImage()
                if ($imageName) {
                    $imagePath = $this->getParameter('uploads_directory') . '/' . $imageName;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $em->remove($item);
                $em->flush();

                $this->addFlash('success', 'Annonce supprimée.');
            } else {
                $this->addFlash('danger', 'Vous n\'avez pas les droits pour supprimer cette annonce.');
            }
        } else {
            $this->addFlash('danger', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute(
            $this->isGranted('ROLE_ADMIN') ? 'admin_listing_index' : 'home'
        );
    }
}
