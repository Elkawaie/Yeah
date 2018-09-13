<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ClientsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nom', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('prenom', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('adresse', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('CodePostal', IntegerType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('DateNaissance', BirthdayType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'widget' => 'single_text',
                ))
                ->add('Ville', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }

}
