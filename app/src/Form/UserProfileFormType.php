<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('username')
            ->add('firstname')
            ->add('lastname')
            // ->add('email')
            ->add('phoneNumber')
            ->add('street')
            ->add('addressComplement')
            ->add('postalCode')
            ->add('city');
            
        // ajout des rôles modifiables
        $builder->add('roles', ChoiceType::class, [
            'choices'  => [
                'Conducteur' => 'ROLE_CONDUCTEUR',
                'Passager'   => 'ROLE_PASSAGER',
            ],
            'expanded' => true,  // checkbox
            'multiple' => true,  // plusieurs choix possibles
            'label'    => 'Votre rôle',
        ]);
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
