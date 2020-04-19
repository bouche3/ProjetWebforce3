<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PassEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'oldPassword',
                PasswordType::class,
                [
                    'label' => 'Renseigner le mot de passe actuel',
                    'mapped' => false
                ]
                )
            ->add(
                'plainpassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Nouveau mot de passe',
                        'help' => 'Le mot de passe doit faire entre 6 et 10 caractères et peut comporter des lettres, 
                        des chiffres et des caractères spéciaux'
                    ],
                    'second_options' => [
                        'label' => 'Confirmer le nouveau mot de passe'
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
