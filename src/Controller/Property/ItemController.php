<?php 

namespace App\Controller\Property;

use App\Service\PropertyProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{
    #[Route('/add', name: 'add')]
     public function add(Request $request): Response
     {
     if ($request->isMethod('POST')) {
        //Récupération des données du formulaire
        $title = $request->request->get('title');
        $propertyTypeId = (int)$request->request->get('property_type');
        $price = (float)$request->request->get('price');
        $city = $request->request->get('location');
        $transaction = $request->request->get('transaction_type');
        $description = $request->request->get('description');

        //Gestion de l’image uploadée 
        $imageFile = $request->files->get('image');
        $imgPath = null;

        if ($imageFile) {
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();
            $imageFile->move($this->getParameter('uploads_directory'), $newFilename);
            $imgPath = '/uploads/properties/' . $newFilename;
        } else {
            $imgPath = '/uploads/properties/default.webp';
        }

        //BDD

        //Message flash
        $this->addFlash('success', 'Annonce ajoutée avec succès !');

        //Redirection
        return $this->redirectToRoute('add');
    }

    // Affichage du formulaire
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
     public function update(int $item, PropertyProvider $provider, Request $request): Response
     {
     //Récupération de la propriété à modifier
          $properties = $provider->getAllProperties();
          $property = null;

          foreach ($properties as $p) {
               if ($p['id'] === $item) {
                    $property = $p;
                    break;
               }
          }

          if (!$property) {
               throw $this->createNotFoundException("Propriété non trouvée.");
          }

     //Si le formulaire est soumis en POST
     if ($request->isMethod('POST')) {
          // Récupérer les données envoyées par le formulaire
          $title = $request->request->get('title');
          $propertyTypeId = (int)$request->request->get('property_type');
          $price = (float)$request->request->get('price');
          $city = $request->request->get('location');
          $transaction = $request->request->get('transaction_type');
          $description = $request->request->get('description');

          // mise à jour
          $property['title'] = $title;
          $property['propertyTypeId'] = $propertyTypeId;
          $property['price'] = $price;
          $property['city'] = $city;
          $property['transaction'] = $transaction;
          $property['description'] = $description;


          $this->addFlash('success', 'Annonce mise à jour.');

          // Redirection ou affichage
          return $this->redirectToRoute('update', ['item' => $item]);
     }

     //Si GET → afficher le formulaire avec données existantes
     return $this->render('property/update.html.twig', [
          'property' => $property
     ]);
     }


      #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(int $id, Request $request, ListingRepository $repo, EntityManagerInterface $em): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $id, $submittedToken)) {
            $property = $repo->find($id);
            if ($property && ($this->getUser() === $property->getUser() || $this->isGranted('ROLE_ADMIN'))) {
                $em->remove($property);
                $em->flush();
                $this->addFlash('success', 'Annonce supprimée.');
            }
        }

        return $this->redirectToRoute('home');
    }
}