<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Country;
use App\Entity\Template;
use App\Entity\TravelCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'city',
                TextType::class,
                [
                    'label'=>'Ville(s) de votre voyage'
                ]
            )
            ->add(
                'title',
                TextType::class,
                [
                    'label'=>'Le titre de votre article'
                ]
            )
            ->add(
                'countryid',
                EntityType::class,
                [
                    'label'=>'Le pays de votre voyage',
                    'class'=>Country::class,
                    'choice_label'=>'country_name',
                    'placeholder'=>'Choisissez un pays'
                ]
            )
            ->add(
                'categoryid',
                EntityType::class,
                [
                    'label'=>'Le type de voyage',
                    'class'=>TravelCategory::class,
                    'choice_label'=>'category_name',
                    'placeholder'=>'Choisissez le type de voyage'
                ]
            )
            ->add(
                'nameTemplate',
                EntityType::class,
                [
                    'label'=>'La mise en page',
                    'class'=>Template::class,
                    'choice_label'=>'template_name',
                    'placeholder'=>'Choisissez votre mise en page'

                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
