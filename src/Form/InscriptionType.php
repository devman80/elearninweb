<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Inscription;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InscriptionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('prenom', TextType::class, [
                    'required' => true,
                 ])
                   ->add('nom', TextType::class, [
                    'required' => true,
              
                ])
                ->add('commune', EntityType::class, [
                    'class' => Commune::class,
                    'required' => true,
                    'mapped' => true,
                    'attr' => array('class' => 'select2'),
                    'placeholder' => '--Choix commune --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                        // ->where('f.deletedAt IS NULL')
                        ->orderBy('f.libelle', 'DESC');
                    },
                    'choice_label' => function ($commune) {
                        return $communes[$commune->getId()] = $commune->getLibelle();
                    },
                ])
                ->add('brochure', FileType::class, [
                    'label' => 'Photo',
                    // unmapped means that this field is not associated to any entity property
                    'mapped' => false,
                    // make it optional so you don't have to re-upload the PDF file
                    // every time you edit the Product details
                    'required' => false,
                    // unmapped fields can't define their validation using annotations
                    // in the associated entity, so you can use the PHP constraint classes
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/*',
                            ],
                            'mimeTypesMessage' => 'Verifiez le format svp ou la taille',
                                ])
                    ],
                ])
                ->add('cmu', TextType::class, [
                    'label' => 'N° CMU',
                    'required' => false,
             
                ])

                ->add('diplome', FileType::class, [
                    'label' => 'Diplome',
                    // unmapped means that this field is not associated to any entity property
                    'mapped' => false,
                    // make it optional so you don't have to re-upload the PDF file
                    // every time you edit the Product details
                    'required' => false,
                    // unmapped fields can't define their validation using annotations
                    // in the associated entity, so you can use the PHP constraint classes
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/*',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain'
                            ],
                            'mimeTypesMessage' => 'Verifiez le format svp ou la taille',
                                ])
                    ],
                ])
                ->add('cni', FileType::class, [
                    'label' => 'Pièce',
                    // unmapped means that this field is not associated to any entity property
                    'mapped' => false,
                    // make it optional so you don't have to re-upload the PDF file
                    // every time you edit the Product details
                    'required' => false,
                    // unmapped fields can't define their validation using annotations
                    // in the associated entity, so you can use the PHP constraint classes
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/*',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain'
                            ],
                            'mimeTypesMessage' => 'Verifiez le format svp ou la taille',
                                ])
                    ],
                ])
                            
                            
                                       ->add('certificat', FileType::class, [
                    'label' => 'Pièce',
                    // unmapped means that this field is not associated to any entity property
                    'mapped' => false,
                    // make it optional so you don't have to re-upload the PDF file
                    // every time you edit the Product details
                    'required' => false,
                    // unmapped fields can't define their validation using annotations
                    // in the associated entity, so you can use the PHP constraint classes
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/*',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain'
                            ],
                            'mimeTypesMessage' => 'Verifiez le format svp ou la taille',
                                ])
                    ],
                ])
                            
                ->add('extrait', FileType::class, [
                    'label' => 'Extrait de naissance',
                    // unmapped means that this field is not associated to any entity property
                    'mapped' => false,
                    // make it optional so you don't have to re-upload the PDF file
                    // every time you edit the Product details
                    'required' => false,
                    // unmapped fields can't define their validation using annotations
                    // in the associated entity, so you can use the PHP constraint classes
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/*',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain'
                            ],
                            'mimeTypesMessage' => 'Verifiez le format svp ou la taille',
                                ])
                    ],
                ])
                ->add('sexe', ChoiceType::class, [
                    'required' => true,
                    'choices' => [
                        'Homme' => 'Homme',
                        'Femme' => 'Femme',
                    ],
                ])
                ->add('contact')
                ->add('telephone')
                ->add('datenaissance', DateType::class, [
                    // renders it as a single text box
                    'widget' => 'single_text',
                    'required' => true,
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                        ]
                )
                ->add('lieuresidence')
                ->add('numpiece', TextType::class, [
                    'label' => 'N° de pièce',
                    'required' => false,
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^[-a-zA-Z0-9 .]+$/',
                            'match' => true,
                            'message' => 'sont seulement acceptés: les chiffres et les lettres',
                                ])
                    ],
                ])
                ->add('typepiece', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => [
                        'Aucun' => 'Aucun',
                        'CNI' => 'CNI',
                        'Attestation' => 'Attestation',
                        'Pastport' => 'Pastport',
                        'Permis' => 'Permis',
                        'Carte professionnelle' => 'Carte professionnelle',
                        'Autre' => 'Autre',
                    ],
                ])
                ->add('typehandicap', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => [
                        'Non' => 'Non',
                        'Oui' => 'Oui',
                    ],
                ])
            
                ->add('paysnaiss', CountryType::class, array('label' => 'Pays de naissance*',
                    'preferred_choices' => array('CI'),
                    'choice_translation_locale' => null
                ))
                ->add('paysvit', CountryType::class, array('label' => 'Pays de residence*',
                    'preferred_choices' => array('CI'),
                    'choice_translation_locale' => null
                ))
                ->add('typepiece', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => [
                        'Aucun' => 'Aucun',
                        'CNI' => 'CNI',
                        'Attestation' => 'Attestation',
                        'Pastport' => 'Pastport',
                        'Permis' => 'Permis',
                        'Carte professionnelle' => 'Carte professionnelle',
                        'Autre' => 'Autre',
                    ],
                ])
      
                ->add('valider', SubmitType::class);
        
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }

}
