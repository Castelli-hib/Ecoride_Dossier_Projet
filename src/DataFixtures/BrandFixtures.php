<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class BrandFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // Liste des marques alignée sur ton SQL
        $brands = [
            ['model' => 'Peugeot 208',       'motorization' => 'Essence',    'places' => 5, 'category' => 'Citadine', 'ac' => true,  'luggage' => false, 'gps' => true],
            ['model' => 'Renault Clio',       'motorization' => 'Diesel',     'places' => 5, 'category' => 'Citadine', 'ac' => true,  'luggage' => false, 'gps' => false],
            ['model' => 'Citroen C3',         'motorization' => 'Essence',    'places' => 5, 'category' => 'Citadine', 'ac' => true,  'luggage' => false, 'gps' => true],
            ['model' => 'Toyota Yaris',       'motorization' => 'Hybride',    'places' => 5, 'category' => 'Citadine', 'ac' => true,  'luggage' => false, 'gps' => true],

            ['model' => 'Peugeot 3008',      'motorization' => 'Diesel',     'places' => 5, 'category' => 'SUV',      'ac' => true,  'luggage' => true,  'gps' => true],
            ['model' => 'Renault Captur',     'motorization' => 'Essence',    'places' => 5, 'category' => 'SUV',      'ac' => true,  'luggage' => true,  'gps' => false],
            ['model' => 'Nissan Qashqai',     'motorization' => 'Diesel',     'places' => 5, 'category' => 'SUV',      'ac' => true,  'luggage' => true,  'gps' => true],

            ['model' => 'Volkswagen Golf',    'motorization' => 'Diesel',     'places' => 5, 'category' => 'Compacte', 'ac' => true,  'luggage' => false, 'gps' => true],
            ['model' => 'Ford Focus',         'motorization' => 'Essence',    'places' => 5, 'category' => 'Compacte', 'ac' => true,  'luggage' => false, 'gps' => false],

            ['model' => 'Tesla Model 3',      'motorization' => 'Electrique','places' => 5, 'category' => 'Berline',  'ac' => true,  'luggage' => false, 'gps' => true],
            ['model' => 'BMW Serie 3',        'motorization' => 'Diesel',     'places' => 5, 'category' => 'Berline',  'ac' => true,  'luggage' => false, 'gps' => true],

            ['model' => 'Dacia Duster',       'motorization' => 'Diesel',     'places' => 5, 'category' => 'SUV',      'ac' => true,  'luggage' => true,  'gps' => false],
            ['model' => 'Fiat Panda',         'motorization' => 'Essence',    'places' => 4, 'category' => 'Citadine', 'ac' => false, 'luggage' => false, 'gps' => false],
        ];

        $index = 1;
        foreach ($brands as $data) {
            // Vérification idempotente : on cherche si le modèle existe déjà
            $existing = $manager->getRepository(Brand::class)->findOneBy(['model' => $data['model']]);
            if ($existing) {
                // Référence pour les autres fixtures si déjà présent
                $this->addReference('brand_' . $index, $existing);
                $index++;
                continue;
            }

            $brand = new Brand();
            $brand->setModel($data['model']);
            $brand->setMotorization($data['motorization']);
            $brand->setNumberPlace($data['places']);
            $brand->setCategory($data['category']);
            $brand->setAirConditioning($data['ac']);
            $brand->setLuggageRack($data['luggage']);
            $brand->setGps($data['gps']);

            $manager->persist($brand);

            // Référence pour VehicleFixtures
            $this->addReference('brand_' . $index, $brand);
            $index++;
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['brand'];
    }
}
