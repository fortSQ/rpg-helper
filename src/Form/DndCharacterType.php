<?php

namespace App\Form;

use App\Entity\DndCharacter;
use App\Entity\DndClass;
use App\Entity\DndRace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DndCharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label'  => 'Name',
                'help' => 'Only letters, digits, and underscore.',
                'attr' => ['autofocus' => true],
            ])
            ->add('level',TextType::class)
            ->add('experience_points',TextType::class)
            ->add('money',TextType::class)
            ->add('strength',TextType::class)
            ->add('dexterity',TextType::class)
            ->add('constitution',TextType::class)
            ->add('intelligence',TextType::class)
            ->add('wisdom',TextType::class)
            ->add('charisma',TextType::class)
            ->add('armor_class',TextType::class)
            ->add('class', EntityType::class, [
                'class'       => DndClass::class,
                'placeholder' => 'Choose a class'
            ])
            ->add('race', EntityType::class, [
                'class' => DndRace::class,
                'placeholder' => 'Choose a race'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DndCharacter::class,
        ]);
    }
}
