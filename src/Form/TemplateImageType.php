<?php

namespace App\Form;

use App\Entity\ImageTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'banner',
                FileType::class,
                [
                    'label'=>'Bannière',
                    'help'=>'Cette photo sera utilisée pour l\'affichage de votre article',
                    'required' => false
                ]
            )
            ->add(
                'introduction',
                TextareaType::class,
                [
                    'label'=>'Veuillez indiquer une introduction pour votre aventure',
                    'required' =>false
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
                'img3',
                FileType::class,
                [
                    'label'=>'image3',
                    'required'=>false
                ]
            )
            ->add(
                'img4',
                FileType::class,
                [
                    'label'=>'image4',
                    'required'=>false
                ]
            )
            ->add(
                'img5',
                FileType::class,
                [
                    'label'=>'image5',
                    'required'=>false
                ]
            )
            ->add(
                'img6',
                FileType::class,
                [
                    'label'=>'image6',
                    'required'=>false
                ]
            )
            ->add(
                'img7',
                FileType::class,
                [
                    'label'=>'image7',
                    'required'=>false
                ]
            )
            ->add(
                'img8',
                FileType::class,
                [
                    'label'=>'image8',
                    'required'=>false
                ]
            )
            ->add(
                'img9',
                FileType::class,
                [
                    'label'=>'image9',
                    'required'=>false
                ]
            )
            ->add(
                'img10',
                FileType::class,
                [
                    'label'=>'image10',
                    'required'=>false
                ]
            )
            ->add(
                'img11',
                FileType::class,
                [
                    'label'=>'image11',
                    'required'=>false
                ]
            )
            ->add(
                'img12',
                FileType::class,
                [
                    'label'=>'image12',
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
                'content3',
                TextareaType::class,
                [
                    'label'=>'content3',
                    'required' => false
                ]
            )
            ->add(
                'content4',
                TextareaType::class,
                [
                    'label'=>'content4',
                    'required' => false
                ]
            )
            ->add(
                'content5',
                TextareaType::class,
                [
                    'label'=>'content5',
                    'required' => false
                ]
            )
            ->add(
                'content6',
                TextareaType::class,
                [
                    'label'=>'content6',
                    'required' => false
                ]
            )
            ->add(
                'content7',
                TextareaType::class,
                [
                    'label'=>'content7',
                    'required' => false
                ]
            )
            ->add(
                'content8',
                TextareaType::class,
                [
                    'label'=>'content8',
                    'required' => false
                ]
            )
            ->add(
                'content9',
                TextareaType::class,
                [
                    'label'=>'content9',
                    'required' => false
                ]
            )
            ->add(
                'content10',
                TextareaType::class,
                [
                    'label'=>'content10',
                    'required' => false
                ]
            )
            ->add(
                'content11',
                TextareaType::class,
                [
                    'label'=>'content11',
                    'required' => false
                ]
            )
            ->add(
                'content12',
                TextareaType::class,
                [
                    'label'=>'content12',
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
            'data_class' => ImageTemplate::class,
        ]);
    }
}
