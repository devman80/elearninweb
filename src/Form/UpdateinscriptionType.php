<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateinscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('brochureFilename')
            ->add('sexe')
            ->add('contact')
            ->add('statutmatri')
            ->add('datenaissance')
            ->add('lieuresidence')
            ->add('paysnaiss')
            ->add('paysvit')
            ->add('typepiece')
            ->add('numpiece')
            ->add('handicap')
            ->add('typehandicap')
            ->add('telephone')
            ->add('cmu')
            ->add('extraitFilename')
            ->add('matricule')
            ->add('diplomeFilename')
            ->add('cniFilename')
            ->add('cniFilenamerecto')
    
            ->add('certificatFileName')

            ->add('section')
            ->add('commune')
  ->add('valider', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
