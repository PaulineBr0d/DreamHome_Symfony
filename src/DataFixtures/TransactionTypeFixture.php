<?php

namespace App\DataFixtures;

use App\Entity\TransactionType;
use App\Enum\TransactionTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TransactionTypeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (TransactionTypeEnum::cases() as $key => $transactionTypeEnum) {
            $transactionType = new TransactionType();
            $transactionType->setName($transactionTypeEnum->value);

            $this->addReference('transaction_type_' . $key, $transactionType);
            $manager->persist($transactionType);
        }

        $manager->flush();
    }
}