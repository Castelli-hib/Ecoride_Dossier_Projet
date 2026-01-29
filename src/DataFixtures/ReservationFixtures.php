<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Route;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {

            /** @var Route $route */
            $route = $this->getReference('route_' . $i, Route::class);
            $conducteur = $route->getUser();

            $reservationCount = rand(1, 4);
            $usedPassengers = [];

            for ($j = 1; $j <= $reservationCount; $j++) {

                do {
                    $userIndex = rand(1, 10);
                    /** @var User $passager */
                    $passager = $this->getReference('user_' . $userIndex, User::class);
                } while (
                    $passager === $conducteur ||
                    in_array($userIndex, $usedPassengers, true)
                );

                $usedPassengers[] = $userIndex;

                $reservation = new Reservation();
                $reservation->setDateReservation(
                    new \DateTime('-' . rand(1, 7) . ' days')
                );
                $reservation->setIsConfirmed(rand(1, 100) <= 70);
                $reservation->setPassager($passager);
                $reservation->setRoute($route);

                $manager->persist($reservation);

                // 🔑 Référence sécurisée pour AvisFixtures
                $this->addReference(
                    'reservation_' . $i . '_' . $j,
                    $reservation
                );
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            RouteFixtures::class,
        ];
    }
}
