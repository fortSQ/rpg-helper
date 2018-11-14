<?php

namespace App\Form;

use App\Entity\DndCharacter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DndCharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('level')
            ->add('experience_points')
            ->add('money')
            ->add('strength')
            ->add('dexterity')
            ->add('constitution')
            ->add('intelligence')
            ->add('wisdom')
            ->add('charisma')
            ->add('armor_class')
            ->add('class')
            ->add('race')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DndCharacter::class,
        ]);
    }
}
