<?php

namespace App\DataFixtures;

use App\Entity\Credit;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class CreditFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Pour chaque utilisateur standard
        for ($i = 1; $i <= 10; $i++) {

            /** @var User $user */
            $user = $this->getReference('user_' . $i, User::class);

            $balance = '0.00';

            // 3 à 6 mouvements par utilisateur
            $creditCount = rand(3, 6);

            for ($j = 1; $j <= $creditCount; $j++) {

                $credit = new Credit();
                $credit->setUser($user);

                // Type de transaction
                $types = ['paiement', 'gain', 'bonus'];
                $type = $types[array_rand($types)];
                $credit->setType($type);

                // Montant selon le type
                if ($type === 'paiement') {
                    $amount = '-' . number_format(rand(5, 20), 2);
                    $credit->setDescription('Paiement d’un trajet');
                } elseif ($type === 'gain') {
                    $amount = number_format(rand(10, 30), 2);
                    $credit->setDescription('Gain suite à un trajet effectué');
                } else {
                    $amount = number_format(rand(2, 10), 2);
                    $credit->setDescription('Bonus de fidélité');
                }

                $credit->setAmount($amount);

                // Calcul du solde
                $balance = bcadd($balance, $amount, 2);
                $credit->setBalanceAfter($balance);

                // Date réaliste
                $credit->setCreatedAt(
                    new \DateTime('-' . rand(1, 30) . ' days')
                );

                $manager->persist($credit);
            }
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
