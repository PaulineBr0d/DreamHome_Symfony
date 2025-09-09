<?php 
namespace App\Controller\Property;

use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Repository\ListingRepository;
use App\Repository\PropertyTypeRepository;
use App\Repository\TransactionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter; // Optionnel, si tu utilises annotations

class ItemController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add( Request $request,
        EntityManagerInterface $em,
        PropertyTypeRepository $propertyTypeRepo,
        TransactionTypeRepository $transactionTypeRepo
    ): Response {
        if ($request->isMethod('POST')) {
            $title = $request->request->get('title');
            $price = (float)$request->request->get('price');
            $city = $request->request->get('location');
            $description = $request->request->get('description');
            $propertyTypeId = (int) $request->request->get('property_type');
            $transactionTypeId = (int) $request->request->get('transaction_type');

            $item = new Listing();
            $item->setTitle($title);
            $item->setPrice($price);
            $item->setCity($city);
            $item->setDescription($description);
            $item->setPropertyType($propertyType);
            $item->setTransactionType($transactionType);
 
            // Dates de création et mise à jour
            $now = new \DateTimeImmutable();
            $item->setCreatedAt($now);
            $item->setUpdatedAt($now);

            // associer l'utilisateur connecté
            $item->setUser($this->getUser());

            $em->persist($listing);
            $em->flush();

            $this->addFlash('success', 'Annonce ajoutée avec succès !');
            return $this->redirectToRoute('add');
        }

        return $this->render('property/add.html.twig', [
            'transaction' => $transactionTypeRepo->findAll(),
            'propertyTypes' => $propertyTypeRepo->findAll(),
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'])]
    public function update(
        #[MapEntity(id: 'id')] Listing $item,  
        Request $request,
        EntityManagerInterface $em,
        PropertyTypeRepository $propertyTypeRepo,
        TransactionTypeRepository $transactionTypeRepo
    ): Response {
        if ($request->isMethod('POST')) {
            $title = $request->request->get('title');
            $price = (float)$request->request->get('price');
            $city = $request->request->get('location');
            $description = $request->request->get('description');
            $propertyTypeId = (int) $request->request->get('property_type');
            $transactionTypeId = (int) $request->request->get('transaction_type');
             
            $propertyType = $propertyTypeRepo->find($propertyTypeId);
            $transactionType = $transactionTypeRepo->find($transactionTypeId);

            $item->setTitle($title);
            $item->setPrice($price);
            $item->setCity($city);
            $item->setDescription($description);
            $item->setPropertyType($propertyType);
            $item->setTransactionType($transactionType);
            $item->setUpdatedAt(new \DateTimeImmutable());

            $em->flush();

            $this->addFlash('success', 'Annonce mise à jour.');
            return $this->redirectToRoute('update', ['listing' => $item->getId()]);
        }

        return $this->render('property/update.html.twig', [
            'property' => $item,
            'transaction' => $transactionTypeRepo->findAll(),
            'propertyTypes' => $propertyTypeRepo->findAll(),
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
