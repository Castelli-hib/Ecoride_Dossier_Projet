<?php

namespace App\Form;

use App\Entity\Vehicle;
use App\Entity\Brand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VehicleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // 🔹 Lien avec Brand (relation Doctrine)
            ->add('brandVehicle', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'model',
                'label' => 'Véhicule',
                'placeholder' => 'Choisir un modèle',
            ])

            // 🔹 Année
            ->add('year', TextType::class, [
                'label' => 'Année',
            ])

            // 🔹 Kilométrage
            ->add('kilometer', IntegerType::class, [
                'label' => 'Kilométrage',
            ])

            // 🔹 Actif / Inactif
            ->add('isActif', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
