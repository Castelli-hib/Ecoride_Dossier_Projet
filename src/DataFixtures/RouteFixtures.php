<?php

namespace App\DataFixtures;

use App\Entity\Route;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class RouteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {

            $route = new Route();

            if ($i % 2 === 0) {
                // Trajet avec correspondance
                $route->setDepartureTown('Porto-Vecchio');
                $route->setArrivalTown('Bastia');
                $route->setCorrespondance(true);
                $route->setCorrespondanceDetail('Via Corte');
                $route->setTravelTime(210);

                // Règles plus strictes
                $route->setAllowAnimal(false);
                $route->setAllowSmoker(false);
                $route->setAllowMusic(true);
                $route->setAllowDisabledEquipment(true);
            } else {
                // Trajet direct
                $route->setDepartureTown('Ajaccio');
                $route->setArrivalTown('Propriano');
                $route->setCorrespondance(false);
                $route->setCorrespondanceDetail(null);
                $route->setTravelTime(75);

                // Règles plus souples
                $route->setAllowAnimal(true);
                $route->setAllowSmoker(false);
                $route->setAllowMusic(true);
                $route->setAllowDisabledEquipment(false);
            }

            $route->setDepartureDay(new \DateTime('+' . $i . ' days'));
            $route->setDepartureTime(new \DateTime('08:00'));

            /** @var User $user */
            $user = $this->getReference('user_' . $i, User::class);
            $route->setUser($user);

            $manager->persist($route);
            $this->addReference('route_' . $i, $route);
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

