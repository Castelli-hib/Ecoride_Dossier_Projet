<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class VehicleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Marque
            ->add('brand', TextType::class, [
                'label' => 'Marque',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2]),
                ],
            ])

            // Modèle
            ->add('model', TextType::class, [
                'label' => 'Modèle',
                'constraints' => [
                    new NotBlank(),
                ],
            ])

            // Immatriculation
            ->add('licensePlate', TextType::class, [
                'label' => 'Immatriculation',
                'attr' => ['placeholder' => 'AB-123-CD'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 7, 'max' => 10]),
                ],
            ])

            // Nombre de places
            ->add('seats', IntegerType::class, [
                'label' => 'Nombre de places',
            ])

            // Carburant
            ->add('fuelType', ChoiceType::class, [
                'label' => 'Carburant',
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Électrique' => 'electrique',
                    'Hybride' => 'hybride',
                    'GPL' => 'gpl',
                ],
            ])

            // Couleur
            ->add('color', TextType::class, [
                'label' => 'Couleur',
            ])

            // Photo (upload)
            ->add('photo', FileType::class, [
                'label' => 'Photo du véhicule',
                'mapped' => false, // important !
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Formats acceptés : JPG, PNG',
                    ])
                ],
            ])

            // Année
            ->add('year', IntegerType::class, [
                'label' => 'Année',
            ])

            // Description
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])

            // Statut actif/inactif
            ->add('isActive', CheckboxType::class, [
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
