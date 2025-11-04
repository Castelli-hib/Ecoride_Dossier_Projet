<?php

namespace App\DataFixtures;

use App\Entity\Route;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RouteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $route = new Route();
            $route->setDepartureTown('Ville départ '.$i);
            $route->setArrivalTown('Ville arrivée '.$i);
            $route->setDepartureDay(new \DateTime("+{$i} days"));
            $route->setDepartureTime(new \DateTime('08:00'));
            $route->setTravelTime(rand(60, 240));
            $route->setCorrespondance(false);
            $route->setCorrespondanceDetail('');

            // 🔗 Associer un utilisateur existant (si tu as UserFixtures)
            $user = $manager->getRepository(User::class)->findOneBy([]);
            if ($user) {
                $route->setUser($user);
            }

            $manager->persist($route);
        }

        $manager->flush();
    }
}
