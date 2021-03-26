<?php

namespace App\Form;

use App\Entity\Booking;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginsAt', DateType::class, [
                'widget' => 'single_text',
                'data' => empty($options['beginsAt']) ? null : new DateTime($options['beginsAt']),
                'html5' => false,
            ])
            ->add('endsAt', DateType::class, [
                'widget' => 'single_text',
                'data' => empty($options['beginsAt']) ? null : new DateTime($options['endsAt']),
                'html5' => false
            ])
            ->add('totalOccupiers', ChoiceType::class, [
                'choices' => array_slice(range(0, $options['capacity']), 1, null, true),
                'data' => 1
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'capacity' => 1,
            'beginsAt' => null,
            'endsAt' => null
        ]);
    }
}
