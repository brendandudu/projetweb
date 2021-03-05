<?php

namespace App\Form;

use App\Entity\Lodging;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LodgingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('capacity')
            ->add('space')
            ->add('internetAvailable')
            ->add('currentCondition')
            ->add('description')
            ->add('nightPrice')
            ->add('picture')
            ->add('updatedAt')
            ->add('lat')
            ->add('lon')
            ->add('fullAddress')
            ->add('postalCode')
            ->add('lodgingType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lodging::class,
        ]);
    }
}
