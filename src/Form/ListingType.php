<?php

namespace App\Form;

use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as FileConstraint;

class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null,[
            'required' => True,
            'label' => "Titre de l'annonce",
            ])
            ->add('price')
            ->add('city')
            ->add('description')
            ->add('uploadedFile', FileType::class, [
                'label' => 'Upload Image',
                'mapped'=> false,
                'required'=> false,
                'constraints' => [
                   new FileConstraint([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/jpg'],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG/PNG).',
                    ]),
                 ]
            ]
            )
            
            ->add('transactionType', EntityType::class, [
                'class' => TransactionType::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un type de transaction',
            ])
            ->add('propertyType', EntityType::class, [
                'class' => PropertyType::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un type de propriété',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
