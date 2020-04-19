<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\TravelCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchArticleIndexType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add(
                'countryid',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
