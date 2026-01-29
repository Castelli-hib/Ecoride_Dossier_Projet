<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use App\Entity\User;
use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;


class VehicleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 15; $i++) {

            $vehicle = new Vehicle();

            $vehicle->setYear((string) $faker->numberBetween(2005, 2023));
            $vehicle->setStatus($faker->randomElement(['disponible', 'maintenance']));
            $vehicle->setKilometer($faker->numberBetween(5000, 250000));
            $vehicle->setIsActif(true);

            /** @var User $user */
            $user = $this->getReference(
                'user_' . $faker->numberBetween(1, 10),
                User::class
            );

            /** @var Brand $brand */
            $brand = $this->getReference(
                'brand_' . $faker->numberBetween(1, 3),
                Brand::class
            );

            $vehicle->setUserVehicle($user);
            $vehicle->setBrandVehicle($brand);

            $manager->persist($vehicle);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            BrandFixtures::class,
        ];
    }
}
