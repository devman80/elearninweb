<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Paiement;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PaiementType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
       // $inscription = $options['inscription'];
        $builder
                ->add('modepaiement', ChoiceType::class, [
                    'required' => true,
                    'choices' => [
                        'Espece' => 'Espece',
                        'Depot' => 'Depot',
                        'Cheque' => 'Cheque',
                    ],
                ])
                ->add('datepaiement', DateType::class, [
                    // renders it as a single text box
                    'widget' => 'single_text',
                    'required' => true,
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('montantpaiement')
                ->add('restepaie', TextType::class)
                ->add('inscrit', HiddenType::class)
                ->add('inscription',ChoiceType::class,['placeholder'=>'Auditeur(Choisir un auditeur)'])
               ->add('section', EntityType::class, [
                    'class' => Section::class,
                    'placeholder' => '-- Section --',
                   'choice_label' =>'libelle'
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
        $formModifier = function (FormInterface $form, Section $section = null): void {
            $inscriptions = null === $section ? [] : $section->getInscriptions();

            $form->add('inscription', EntityType::class, [
                'class' => Inscription::class,
                'placeholder' => 'Auditeur(Choisir un auditeur)',
                'choice_label'=>'prenom',
                'choices' => $inscriptions,
            ]);
        };

        $builder->get('section')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier): void {
                $section = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $section);
            }
        );



    }

//    public function configureOptions(OptionsResolver $resolver): void {
//        $resolver->setDefaults([
//            'data_class' => Paiement::class,
//            'inscrit' => null,
//        ]);
//    }

}
