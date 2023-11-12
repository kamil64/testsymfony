<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Tytuł',
                'attr' => [
                    'placeholder' => 'Wpisz tytuł'
                ],
                'help' => 'Wpisz tytuł gry'
            ])
            ->add('description')
            ->add('score')
            ->add('relaseDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
