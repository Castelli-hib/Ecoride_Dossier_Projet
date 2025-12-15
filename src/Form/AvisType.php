<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userRated', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // ou 'username', selon ce que tu veux afficher
                'label' => 'Utilisateur à noter'
            ])
            ->add('note', IntegerType::class, [
                'label' => 'Note (0-5)',
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer l’avis'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
