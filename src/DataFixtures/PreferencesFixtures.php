<?php

namespace App\DataFixtures;

use App\Entity\Preferences;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PreferencesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $preferencesRepository = $manager->getRepository(Preferences::class);

        // On suppose 10 users
        for ($i = 1; $i <= 10; $i++) {

            /** @var User $user */
            $user = $this->getReference('user_' . $i, User::class);

            // 🔍 Vérification OneToOne (clé UNIQUE)
            $existingPreferences = $preferencesRepository->findOneBy([
                'user' => $user
            ]);

            if ($existingPreferences) {
                continue; // 👈 ESSENTIEL
            }

            $preferences = new Preferences();

            // 🎯 Préférences réalistes
            $preferences->setAnimal(rand(0, 100) < 40);
            $preferences->setSmoker(rand(0, 100) < 20);
            $preferences->setMusic(rand(0, 100) < 70);
            $preferences->setDisabledEquipment(rand(0, 100) < 15);
            $preferences->setTrailer(rand(0, 100) < 25);
            $preferences->setUsbCharger(rand(0, 100) < 80);
            $preferences->setTablet(rand(0, 100) < 30);

            // 🔗 Relation obligatoire
            $preferences->setUser($user);

            $manager->persist($preferences);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
