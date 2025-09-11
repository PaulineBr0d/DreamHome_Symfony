<?php

namespace App\DataFixtures;

use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Entity\User;
use App\Enum\PropertyTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ListingFixture extends Fixture implements DependentFixtureInterface
{
    public const TITLES = [
        "Spacieuse villa",
        "Charmant appartement",
        "Maison de campagne",
        "Luxueux penthouse",
        "Studio moderne",
        "Appartement duplex",
        "Propriété avec piscine",
        "Maison familiale",
        "Villa avec vue sur mer",
        "Appartement neuf"
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $listing = new Listing();
            $listing
                ->setCity('Lyon')
                ->setTitle(self::TITLES[array_rand(self::TITLES)])
                ->setDescription($faker->text(100))
                ->setPrice($faker->randomNumber(5, false))
                ->setUser($this->getReference('user_' . rand(0, 3), User::class))
                ->setTransactionType($this->getReference('transaction_type_' . rand(0, 2), TransactionType::class))
                ->setPropertyType($this->getReference('property_type_' . rand(0, 5), PropertyType::class))
            ;

            $manager->persist($listing);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            UserFixture::class,
            TransactionTypeFixture::class,
            PropertyTypeFixture::class,
        ];
    }
}