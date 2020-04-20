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

class MemberEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

             $builder
                 ->add(
                     'pseudo',
                     TextType::class,
                     [
                         'label'=>'Pseudo',
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
                     'status',
                     TextType::class,
                     [
                         'label'=>'Role'
                     ]
                 )
             ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>User::class

        ]);
    }
}
