<?php

namespace App\Form;

use App\Data\SearchLodgingData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchLodgingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cityName', HiddenType::class)
            ->add('postalCodes', HiddenType::class)

            ->add('beginsAt', DateType::class,[
                'widget' => 'single_text',
                "html5" => false,
            ])

            ->add('endsAt', DateType::class,[
                'widget' => 'single_text',
                "html5" => false,
            ])

            ->add('visitors', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchLodgingData::class,
            'method' => 'POST'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'search';
    }
}
