<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Tytuł',
                'attr' => [
                    'placeholder' => 'Wpisz tytuł'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Treść',
                'attr' => [
                    'placeholder' => 'Wpisz treść'
                ]
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
