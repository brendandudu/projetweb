<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('pictureFile', VichImageType::class)
            ->add('phone', TelType::class)
            ->add('sex', ChoiceType::class, [
                'choices' => ['Homme'=>'Homme','Femme'=>'Femme','Autre'=>'Autre'],
                'required' => true,
                'mapped' => false
            ])
            ->add('birthday',DateType::class,[
                'widget' => 'single_text',
                'mapped' => false
            ])
            ->add('country', CountryType::class, [
                'required' => true,
                'mapped' => false
            ])
            ->add('city', TextType::class, ['mapped' => false])
            ->add('avenue', TextType::class, ['mapped' => false])
            ->add('appartment', TextType::class, ['mapped' => false])
            ->add('code', TextType::class, ['mapped' => false])
            ->add('address', TextType::class, ['mapped' => false])



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('email')
//            ->add('firstName')
//            ->add('lastName')
//        ;
//    }
//
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//        ]);
//    }
}
