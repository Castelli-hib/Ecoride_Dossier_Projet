<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AvisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {

            for ($j = 1; $j <= 4; $j++) {

                // 🔒 Sécurité : la réservation peut ne pas exister
                if (!$this->hasReference('reservation_' . $i . '_' . $j, Reservation::class)) {
                    continue;
                }

                /** @var Reservation $reservation */
                $reservation = $this->getReference(
                    'reservation_' . $i . '_' . $j,
                    Reservation::class
                );

                // Pas d’avis si la réservation n’est pas confirmée
                if (!$reservation->isConfirmed()) {
                    continue;
                }

                $route = $reservation->getRoute();
                $conducteur = $route->getUser();
                $passager = $reservation->getPassager();

                // Sécurité : pas d’auto-avis
                if ($conducteur === $passager) {
                    continue;
                }

                $avis = new Avis();
                $avis->setUserRater($passager);
                $avis->setUserRated($conducteur);
                $avis->setRoute($route);

                $note = rand(3, 5);
                $avis->setNotation($note);

                $commentaires = [
                    5 => 'Trajet parfait, conducteur très agréable.',
                    4 => 'Bon trajet, ponctuel et sympathique.',
                    3 => 'Trajet correct, rien à signaler.',
                ];

                $avis->setComment($commentaires[$note]);

                $manager->persist($avis);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ReservationFixtures::class,
            UserFixtures::class,
            RouteFixtures::class,
        ];
    }
}
