<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\Tarif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Doctrine\ORM\EntityRepository;

class TarifType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['id'];

        $builder
                ->add('designation', TextType::class, array(
                    'label' => 'Nom de votre Tarif',
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('tarifHoraire', CheckboxType::class, array(
                    'label' => 'Si votre tarif est un tarif horaire merci de cocher cette case',
                    'attr' => array('class' => 'form-control'),
                    'required' => false,
                ))
                ->add('valeur', IntegerType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'required' => false,
                ))
                ->add('fkEntrepriseTarif', EntityType::class, array(
                    'class' => Entreprise::class,
                    'query_builder' => function (EntityRepository $er) use ($id) {
                        return $er->createQueryBuilder('u')
                                ->select('u')
                                ->where('u.id=' . $id . '');
                    },
                    'mapped' =>false ,
                    'label' => 'Votre entreprise',
                    'attr' => array('class' => 'form-control'),
                    'choice_label' => 'nom'
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tarif::class,
            'id' => 1,
        ]);
        $resolver->setRequired(['id']);
    }

}
