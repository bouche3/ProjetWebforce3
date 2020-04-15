<?php

namespace App\Form;

use App\Entity\Continent;
use App\Entity\Country;
use App\Entity\TravelCategory;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add(
                'keyword',
                TextType::class,
                [
                    'label' => 'Mots clés',
                    'required' => false
                ]
            )
            ->add(
                'pseudo',
                TextType::class,
                [
                    'label' => 'Pseudo',
                    'required' => false
                ]
            )
            ->add(
                'categoryid',
                EntityType::class,
                [
                    'label' => 'Catégorie',
                    'class' => TravelCategory::class,
                    'choice_label' => 'category_name',
                    'placeholder' => 'Choisissez une catégorie',
                    'required' => false
                ]
            )
            ->add(
                'continent',
                EntityType::class,
                [
                    'label' => 'Continent',
                    'class' => Continent::class,
                    'choice_label' => 'continent_name',
                    'placeholder' => 'Choisissez un continent',
                    'required' => false
                ]
            )
            ->add(
                'country',
                EntityType::class,
                [
                    'label' => 'Pays',
                    'class' => Country::class,
                    'placeholder' => 'Choisissez un pays',
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('cy')
                            ->orderBy('cy.countryName', 'ASC');
                    },
                    'choice_attr' => function(Country $country, $key, $value){
                        return ['data-continent' => $country->getContinentName()->getId()];
                    }
                ]
            )
            ->add(
                'start_date',
                DateType::class,
                [
                    'label'=>'Date de début',
                    'required'=>false,
                    'widget'=>'single_text'
                ]
            )
            ->add(
                'end_date',
                DateType::class,
                [
                    'label'=>'Date de fin',
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
