<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SiretSiren', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'N° Siret/Siren'
                ))
            ->add('nom', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Nom de l\'entreprise'
                ))
            ->add('adresse', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
            ->add('CodePostal', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
            ->add('Ville', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
