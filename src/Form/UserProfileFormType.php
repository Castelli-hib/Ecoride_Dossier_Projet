<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('street', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('addressComplement', TextType::class, [
                'label' => 'Complément d’adresse',
                'required' => false,
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ]);

        // 👉 Rôles modifiables uniquement si l’option est activée
        if ($options['show_roles']) {
            $builder->add('roles', ChoiceType::class, [
                'label' => 'Rôle utilisateur',
                'choices'  => [
                    'Conducteur' => 'ROLE_CONDUCTEUR',
                    'Passager'   => 'ROLE_PASSAGER',
                ],
                'expanded' => true,
                'multiple' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'show_roles' => false, // sécurité : désactivé par défaut
        ]);
    }
}
