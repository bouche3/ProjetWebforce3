<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
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
                    'label'=>'Avatar',
                    'required'=>false
                ]
                )
            ->add(
                'plainpassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de passe',
                        'help' => 'Le mot de passe doit faire entre 6 et 10 caractères et peut comporter des lettres, des chiffres et des caractères spéciaux'
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe'
                    ],
                    'invalid_message' => 'La confirmation ne correspond pas au mot de passe'
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
