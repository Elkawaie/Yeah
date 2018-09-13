<?php

namespace App\Form;

use App\Entity\Tva;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TvaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Désignation de la TVA',
                ))
            ->add('taux', IntegerType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tva::class,
        ]);
    }
}
