<?php

namespace App\DataFixtures;

use App\Entity\PropertyType;
use App\Enum\PropertyTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PropertyTypeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (PropertyTypeEnum::cases() as $key => $propertyTypeEnum) {
            $propertyType = new PropertyType();
            $propertyType->setName($propertyTypeEnum->value);

            $this->addReference('property_type_' . $key, $propertyType);
            $manager->persist($propertyType);
        }

        $manager->flush();
    }
}