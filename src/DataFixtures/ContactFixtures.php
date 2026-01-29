<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 20; $i++) {

            $contact = new Contact();

            $contact->setNom($faker->name());
            $contact->setEmail($faker->email());
            $contact->setSujet($faker->optional()->sentence(4));
            $contact->setTelephone($faker->optional()->phoneNumber());
            $contact->setMessage($faker->paragraph(3));
            $contact->setIsRead($faker->boolean(20));

            // createdAt est déjà défini dans le constructeur,
            // mais on peut le surcharger proprement
            $contact->setCreatedAt(
                new \DateTimeImmutable('-' . rand(1, 30) . ' days')
            );

            // updatedAt optionnel
            if ($faker->boolean(30)) {
                $contact->setUpdatedAt(
                    new \DateTimeImmutable('-' . rand(1, 5) . ' days')
                );
            }

            $manager->persist($contact);
        }

        $manager->flush();
    }
}
