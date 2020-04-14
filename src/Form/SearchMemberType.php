<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add(
                'pseudo',
                TextType::class,
                [
                    'label'=>'Pseudo',
                    'required'=>'false'
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label'=>'Email',
                    'required'=>false
                ]
            )

            ->add(
                'start_date',
                DateType::class,
                [
                    'label'=>'Date de debut',
                    'required'=>false,
                    'widget'=>'single_text'
                ]
            )
            ->add(
                'end_date',
                DateType::class,
                [
                    'label'=>'Date de Fin',
                    'required'=>false,
                    'widget'=>'single_text'
                ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
