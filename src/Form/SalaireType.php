<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\Salaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalaireType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('montant')
                ->add('datesalaire', DateType::class, [
                    // renders it as a single text box
                    'widget' => 'single_text',
                    'required' => true,
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('enseignant', EntityType::class, [
                    'class' => Enseignant::class,
                    'required' => true,
                    'mapped' => true,
                    'attr' => array('class' => 'select2'),
                    'placeholder' => '--Choix enseignanc --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                        // ->where('f.deletedAt IS NULL')
                        ->orderBy('f.nom', 'DESC');
                    },
                    'choice_label' => function ($enseignanc) {
                        return $enseignancs[$enseignanc->getId()] = $enseignanc->getNom() . ' ' . $enseignanc->getPrenom();
                    },
                ])
                ->add('save', SubmitType::class, [
                    'attr' => [
                        'value' => 'create-don'
                    ]
                ])
                ->add('saveAndAdd', SubmitType::class, [
                    'attr' => [
                        'value' => 'save-and-add'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Salaire::class,
        ]);
    }

}
