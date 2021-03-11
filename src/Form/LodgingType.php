<?php

namespace App\Form;

use App\Entity\Lodging;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LodgingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('capacity')
            ->add('lodgingType')
            ->add('space')
            ->add('internetAvailable')
            ->add('description')
            ->add('nightPrice', MoneyType::class)
            ->add('pictureFile', VichImageType::class)
            ->add('lat', HiddenType::class)
            ->add('lon', HiddenType::class)
            ->add('fullAddress', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lodging::class,
        ]);
    }
}
