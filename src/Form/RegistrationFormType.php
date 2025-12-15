<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Identité
            ->add('firstname')
            ->add('lastname')

            // Username avec contraintes
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'minimum 3 caractères',
                ],
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Le nom d’utilisateur doit faire au moins {{ limit }} caractères.'
                    ])
                ]
            ])

            // Email
            ->add('email')

            // Téléphone
            ->add('phoneNumber', TextType::class, [
                'required' => false,
            ])

            // Adresse
            ->add('street')
            ->add('addressComplement', TextType::class, [
                'required' => false,
            ])
            ->add('postalCode', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: 20137'
                ]
            ])
            ->add('city')

            // ROLES
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Conducteur' => 'ROLE_CONDUCTEUR',
                    'Passager'   => 'ROLE_PASSAGER',
                ],
                'expanded' => true,
                'multiple' => true,
                'label'    => 'Votre rôle'
            ])

            // Mot de passe
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'id' => 'registration_form_plainPassword'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le mot de passe est obligatoire.']),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                    new PasswordStrength([
                        'minScore' => PasswordStrength::STRENGTH_STRONG,
                        'message' => 'Le mot de passe doit être plus fort.',
                    ]),
                ],
            ])

            // Case RGPD
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
