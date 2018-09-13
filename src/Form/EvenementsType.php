<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Tarif;
use App\Entity\Tva;
use App\Entity\Entreprise;
use App\Entity\Evenements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EvenementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_date', DateTimeType::class)
            ->add('end_date', DateTimeType::class)
            ->add('titre')
            ->add('description')
            ->add('quantite')
            ->add('total')
            ->add('fkTva', EntityType::class, array(
                'class' => Tva::class,
                'choice_label' => 'designation'
            ))
            ->add('fkTarif', EntityType::class, array(
                'class' => Tarif::class,
                'choice_label' => 'designation'
            ))
            ->add('fkClient', EntityType::class, array(
                'class' => Clients::class,
                'choice_label' => 'nom'
            ))
            ->add('fkEntreprise',  EntityType::class, array(
                'class' => Entreprise::class,
                'choice_label' => 'nom'
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenements::class,
        ]);
    }
}
