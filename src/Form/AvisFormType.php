<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Si on est en création, on peut choisir l'utilisateur à noter
        if (!$options['is_edit']) {
            $builder->add('userRated', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Utilisateur à noter',
                'placeholder' => 'Sélectionnez un utilisateur',
            ]);
        }

        $builder
            ->add('notation', IntegerType::class, [
                'label' => 'Note (0-5)',
                'attr' => ['min' => 0, 'max' => 5],
            ])
            ->add('comment', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire',
                'attr' => ['rows' => 4],
            ])
            ->add('save', SubmitType::class, [
                'label' => $options['is_edit'] ? 'Modifier l’avis' : 'Ajouter un avis'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
            'is_edit' => false, // Option pour différencier création / édition
        ]);
    }
}
