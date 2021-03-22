<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('sex', ChoiceType::class, [
                'choices' => ['Homme'=>'Homme','Femme'=>'Femme','Autre'=>'Autre'],
                'required' => true,
            ])
            ->add('birthday',DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('phone', TextType::class)
            ->add('country', ChoiceType::class, [
                'choices' => ['Allemagne'=>'Allemagne','Afrique du sud'=>'Afrique du sud','Belgique'=>'Belgique','Chine'=>'Chine','États-Unis'=>'États-Unis','France'=>'France','Grèce'=>'Grèce'],
                'required' => true,
            ])
            ->add('city', TextType::class)
            ->add('avenue', TextType::class)
            ->add('appartment', TextType::class)
            ->add('code', TextType::class)
            ->add('address', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
