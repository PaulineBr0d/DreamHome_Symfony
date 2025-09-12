<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixture extends Fixture
{
      public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
    $faker = Factory::create('fr_FR');

         // Créer plusieurs utilisateurs classiques
    for ($i = 0; $i < 4; $i++) {
        $user = new User();
        $user
            ->setEmail($faker->email())
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $this->addReference('user_' . $i, $user);
        $manager->persist($user);
    }

    // Créer plusieurs agents
    for ($i = 0; $i < 4; $i++) {
        $agent = new User();
        $agent
            ->setEmail("agent{$i}@mail.com")
            ->setRoles(['ROLE_AGENT'])
            ->setPassword($this->passwordHasher->hashPassword($agent, 'password'));
        $this->addReference('agent_' . $i, $agent);
        $manager->persist($agent);
    }

    // Admin
    $admin = new User();
    $admin
        ->setEmail('admin@mail.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->passwordHasher->hashPassword($admin, 'adminPassword'));
    $this->addReference('admin', $admin);
    $manager->persist($admin);

    $manager->flush();
    }
}
