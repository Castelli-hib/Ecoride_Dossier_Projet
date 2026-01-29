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
        $faker = Factory::create('fr_FR');

        // =========================
        // ADMIN (IDEMPOTENT)
        // =========================
        $adminEmail = 'admin@ecoride.test';

        $admin = $manager->getRepository(User::class)
            ->findOneBy(['email' => $adminEmail]);

        if (!$admin) {
            $admin = new User();
            $admin->setUsername('admin');
            $admin->setFirstname('Admin');
            $admin->setLastname('Ecoride');
            $admin->setEmail($adminEmail);
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setIsVerified(true);

            $admin->setPassword(
                $this->passwordHasher->hashPassword($admin, 'password')
            );

            $manager->persist($admin);
        }

        $this->addReference('user_admin', $admin);

        // =========================
        // USERS STANDARD
        // =========================
        for ($i = 1; $i <= 10; $i++) {
            $email = "user{$i}@ecoride.test";

            // 🔍 Vérifie s'il existe déjà
            $user = $manager->getRepository(User::class)
                ->findOneBy(['email' => $email]);

            if ($user) {
                $this->addReference('user_' . $i, $user);
                continue;
            }

            $user = new User();
            $user->setUsername($faker->userName());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($email);
            $user->setIsVerified(true);

            // ROLE_USER implicite
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, 'password')
            );

            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
