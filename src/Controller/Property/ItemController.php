<?php 

namespace App\Controller\Property;

use App\Entity\Listing;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
        $title = $request->request->get('title');
        # $propertyTypeId = (int)$request->request->get('property_type');
        $price = (float)$request->request->get('price');
        $city = $request->request->get('location');
        #$transaction = $request->request->get('transaction_type');
        $description = $request->request->get('description');

        #$imageFile = $request->files->get('image');
        #$imgPath = null;

        #if ($imageFile) {
        #    $newFilename = uniqid() . '.' . $imageFile->guessExtension();
        #    $imageFile->move($this->getParameter('uploads_directory'), $newFilename);
        #    $imgPath = '/uploads/properties/' . $newFilename;
        #} else {
        #    $imgPath = '/uploads/properties/default.webp';
        #}

        // Création de l'entité Listing
        $listing = new Listing();
        $listing->setTitle($title);
        #$listing->setPropertyType($propertyTypeId); 
        $listing->setPrice($price);
        $listing->setCity($city);
        #$listing->setTransaction($transaction);
        $listing->setDescription($description);
        #$listing->setImagePath($imgPath);
        #$listing->setUser($this->getUser()); // lier l’annonce à l’utilisateur connecté

        $em->persist($listing);
        $em->flush();

        $this->addFlash('success', 'Annonce ajoutée avec succès !');
        return $this->redirectToRoute('add');
    }

    return $this->render('property/add.html.twig', [
        'transaction' => [
            ['id' => 1, 'name' => 'Vente'],
            ['id' => 2, 'name' => 'Location'],
        ],
        'propertyTypes' => [
            ['id' => 1, 'name' => 'Maison'],
            ['id' => 2, 'name' => 'Appartement'],
        ]
    ]);
    }


    #[Route('/update/{item}', requirements: ['item' => '\d+'], name: 'update')]
    public function update(
        int $item,
        ListingRepository $repo,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $listing = $repo->find($item);

        if (!$listing) {
            throw $this->createNotFoundException("Propriété non trouvée.");
        }

    if ($request->isMethod('POST')) {
        $title = $request->request->get('title');
        #$propertyTypeId = (int)$request->request->get('property_type');
        $price = (float)$request->request->get('price');
        $city = $request->request->get('location');
        #$transaction = $request->request->get('transaction_type');
        $description = $request->request->get('description');

        $listing->setTitle($title);
        #$listing->setPropertyType($propertyTypeId);
        $listing->setPrice($price);
        $listing->setCity($city);
        #$listing->setTransaction($transaction);
        $listing->setDescription($description);

        $em->flush();

        $this->addFlash('success', 'Annonce mise à jour.');
        return $this->redirectToRoute('update', ['item' => $item]);
    }   

        return $this->render('property/update.html.twig', [
            'property' => $listing
        ]);
    }

        #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(int $id, Request $request, ListingRepository $repo, EntityManagerInterface $em): Response
    {
        $token = $request->request->get('_token');

    if ($this->isCsrfTokenValid('delete' . $id, $token)) {
        $listing = $repo->find($id);

        if (!$listing) {
            $this->addFlash('danger', 'Annonce introuvable.');
            return $this->redirectToRoute('home');
        }

        if ($this->getUser() === $listing->getUser() || $this->isGranted('ROLE_ADMIN')) {
            $em->remove($listing);
            $em->flush();
            $this->addFlash('success', 'Annonce supprimée.');
        } else {
            $this->addFlash('danger', 'Vous n\'avez pas les droits pour supprimer cette annonce.');
        }
    }

    return $this->redirectToRoute('home');
}

}