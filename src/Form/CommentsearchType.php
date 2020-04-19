<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add(
                'pseudo',
                TextType::class,
                [
                    'label' => 'Pseudo',
                    'required' => false
                ]
            )
            ->add(
                'start_date',
                DateType::class,
                [
                    'label' => 'Date de début',
                    'required' => false,
                    // 1 seul input type date au lieu de 3 select
                    'widget' => 'single_text'
                ]
            )
            ->add(
                'end_date',
                DateType::class,
                [
                    'label' => 'Date de fin',
                    'required' => false,
                    'widget' => 'single_text'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
