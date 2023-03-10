<?php

namespace App\Form;

use App\Entity\Robot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RobotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type', ChoiceType::class, [
                'label' => 'Choice robot type',
                'choices' => [
                    'Brawler' => 'Brawler',
                    'Rouge' => 'Rouge',
                    'Assault' => 'Assault',
                ]
            ])
            ->add('strenght')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Robot::class,
        ]);
    }
}
