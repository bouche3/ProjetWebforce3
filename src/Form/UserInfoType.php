<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'pseudo',
                TextType::class,
                [
                    'label'=>'Pseudo'
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label'=>'Nom'
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'label'=>'Prénom'
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label'=>'Email'
                ]
            )
            ->add(
                'avatar',
                FileType::class,
                [
                    'label'=>'Modifier l\'avatar',
                    'required'=>false,
                    'help' => 'L\'avatar doit être du .jpg ou .png, ne doit pas dépasser 600ko,
                    doit faire au moins 10px de hauteur ou largeur et au maximum 400px de hauteur ou largeur'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
