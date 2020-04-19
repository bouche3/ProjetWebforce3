<?php

namespace App\Form;

use App\Entity\TextTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateTextType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'banner',
                FileType::class,
                [
                    'label'=>'Bannière',
                    'help'=>'Cette photo sera utilisé pour l\'affichage de votre article',
                    'required' => false
                ]
            )
            ->add(
                'introduction',
                TextareaType::class,
                [
                    'label'=>'Veuillez indiquer une introduction pour votre aventure',
                    'required' => false
                ]
            )
            ->add(
                'img1',
                FileType::class,
                [
                    'label'=>'image1',
                    'required'=>false
                ]
            )
            ->add(
                'img2',
                FileType::class,
                [
                    'label'=>'image2',
                    'required'=>false
                ]
            )
            ->add(
                'content1',
                TextareaType::class,
                [
                    'label'=>'content1',
                    'required' => false
                ]
            )
            ->add(
                'content2',
                TextareaType::class,
                [
                    'label'=>'content2',
                    'required' => false
                ]
            )
            ->add(
                'conclusion',
                TextareaType::class,
                [
                    'label'=>'Veuillez indiquer une conclusion pour votre aventure',
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TextTemplate::class,
        ]);
    }
}
