<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Faker : génération de données réalistes
        $faker = Factory::create('fr_FR');

        // =========================
        // ADMIN
        // =========================
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setFirstname('Admin');
        $admin->setLastname('Ecoride');
        $admin->setEmail('admin@ecoride.test');
        $admin->setRoles(['ROLE_ADMIN']); // UNIQUEMENT ADMIN
        $admin->setIsVerified(true);

        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'password')
        );

        $manager->persist($admin);
        $this->addReference('user_admin', $admin);

        // =========================
        // USERS STANDARD
        // =========================
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail("user{$i}@ecoride.test");
            // ❗ PAS DE setRoles → ROLE_USER automatique
            $user->setIsVerified(true);

            $user->setPassword(
                $this->passwordHasher->hashPassword($user, 'password')
            );

            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
