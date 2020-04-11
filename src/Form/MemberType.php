<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
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
                    'label'=>'Lastname'
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'label'=>'firstname'
                ]
            )
            //->add('registrationDate')
            ->add(
                'email',
                TextType::class,
                [
                    'label'=>'email'
                ]
            )
            ->add(
                'confirmPassword',
                RepeatedType::class,
                [
                    'type'=>PasswordType::class,
                    'first_options'=>[
                        'label'=>'Password',
                        'help'=>'Le mot de passe ne doit contenir que des lettres, des chiffres ou _'
                            . ' et faire entre 6 et 20 caractères'
                    ],
                    'second_options'=>[
                        'label'=>'Confirmation du mot de passe'

                    ],
                    'invalid_message' => 'La confirmation ne correspond pas au mot de passe'
                ]

            )
            ->add(
                'avatar',
                TextType::class,
                [
                    'label'=>'Avatar'
                ]

            )
            ->add(
                'status',
                TextType::class,
                [
                    'label'=>'status'
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
