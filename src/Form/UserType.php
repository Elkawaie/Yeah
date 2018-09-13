<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('email', EmailType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('username', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'label' => 'Password',
                        'attr' => array('class' => 'form-control'),
                        ),
                    'second_options' => array(
                        'label' => 'Repeat Password',
                         'attr' => array('class' => 'form-control'),
                        )
                ))
                ->add('fkEntreprise', EntityType::class, array(
                    'class' => Entreprise::class,
                    'attr' => array('class' => 'form-control'),
                    'choice_label' => 'nom',
                    'multiple' => true,
                ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

}
