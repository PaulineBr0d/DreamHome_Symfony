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
        UserRepository $userRepository
    ): Response {
        $listing = new Listing();

        $now = new \DateTimeImmutable();
        $listing->setCreatedAt($now);
        $listing->setUpdatedAt($now);
        //pour test
        $user = $userRepository->find(1);
        if (!$user) {
            throw $this->createNotFoundException;
        }
        $listing->setUser($user);
        
        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          

            $em->persist($listing);
            $em->flush();

            $this->addFlash('success', 'Annonce ajoutée avec succès !');
            return $this->redirectToRoute('listing_show', ['id' => $item->getId()]);
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
    ): Response {
    $form = $this->createForm(ListingType::class, $item);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $item->setUpdatedAt(new \DateTimeImmutable());
        $em->flush();

        $this->addFlash('success', 'Annonce mise à jour.');
        return $this->redirectToRoute('listing_show', ['id' => $item->getId()]);
    }

    return $this->render('property/update.html.twig', [
        'form' => $form->createView(),
        'property' => $item, 
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
                $em->remove($item);
                $em->flush();

                $this->addFlash('success', 'Annonce supprimée.');
            } else {
                $this->addFlash('danger', 'Vous n\'avez pas les droits pour supprimer cette annonce.');
            }
        } else {
            $this->addFlash('danger', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('home');
    }
}
