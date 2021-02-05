<?php

namespace App\Form;

use App\Entity\Availability;
use App\Form\LodgingCapacityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchAvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginsAt', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('endsAt', DateType::class, [
                'widget' => 'single_text'

            ])
            ->add('lodging', LodgingCapacityType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }
}
