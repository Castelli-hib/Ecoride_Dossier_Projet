<?php
// src/Form/SearchRideFormType.php
namespace App\Form;

use App\Model\SearchRide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchRideFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departure', TextType::class, [
                'required' => false,
                'label' => 'Départ',
                'attr' => ['placeholder' => 'Ville de départ']
            ])
            ->add('arrival', TextType::class, [
                'required' => false,
                'label' => 'Destination',
                'attr' => ['placeholder' => 'Ville d’arrivée']
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Quand',
            ])
            ->add('passengers', IntegerType::class, [
                'required' => false,
                'label' => 'Passagers',
                'attr' => ['min' => 1, 'max' => 6]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchRide::class,
            // méthode GET (URL partageable)
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
