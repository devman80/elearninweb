<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('email', EmailType::class, [
                    'label' => 'E-mail',
                    'attr' => ['placeholder' => 'monemail@exemple.com']
                ])
                ->add('prenom', TextType::class, [
                    'required' => true,
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^[0-9a-zA-Z-\s\'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]+$/',
                            'match' => true,
                            'message' => 'sont seulement acceptés: les chiffres, les lettres minuscules et majuscules avec ou sans accents, les espaces, les tirets et les apostrophes',
                                ])
                    ],
                ])
                ->add('nom', TextType::class, [
                    'required' => false,
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^[0-9a-zA-Z-\s\'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]+$/',
                            'match' => true,
                            'message' => 'sont seulement acceptés: les chiffres, les lettres minuscules et majuscules avec ou sans accents, les espaces, les tirets et les apostrophes',
                                ])
                    ],
                ])
                ->add('password', PasswordType::class, ['label' => 'Mot de passe:', 'attr' => ['placeholder' => 'Mot de passe']])
                ->add('brochureFilename', FileType::class, ['label' => 'Photo d\'identité :', 'attr' => ['placeholder' => 'Photo']])
                ->add('contact', TextType::class, [
                    'required' => false,
                    'constraints' => [
                        new RegEx("#^[0-9/? ?]{10,16}$#")
                    ],
                ])
                ->add('telephone', TextType::class, [
                    'required' => true,
                    'constraints' => [
                        new RegEx("#^[0-9/? ?]{10,16}$#")
                    ],
                ])
                ->add('sexe', ChoiceType::class, ['label' => 'Sexe :',
                    'choices' => [
                        'Homme' => 'M',
                        'Femme' => 'F',
                    ]
                ])
                ->add('statutmatri', ChoiceType::class, [
                    'label' => 'Situation matrimoniale:',
                    'attr' => ['placeholder' => 'Situation matrimoniale'],
                    'choices' => [
                        'CELIBATAIRE' => 'CELIBATAIRE',
                        'DIVORCE(E)' => 'DIVORCE(E)',
                        'MARIE(E)' => 'MARIE(E)'
                    ]
                ])
                ->add('datenaissance', DateType::class, ['label' => 'Date de naissance:', 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
                ->add('lieuresidence', TextType::class, ['attr' => ['placeholder' => 'Lieu de residence']])
                ->add('paysnaiss', CountryType::class, array('label' => 'Pays de naissance*',
                    'preferred_choices' => array('CI'),
                    'choice_translation_locale' => null
                ))
                ->add('paysvit', CountryType::class, array('label' => 'Pays de residence*',
                    'preferred_choices' => array('CI'),
                    'choice_translation_locale' => null
                ))
                ->add('typepiece', ChoiceType::class, [
                    'label' => 'Type de pièce:',
                    'attr' => ['placeholder' => 'Type de pièce '],
                    'choices' => [
                        'CNI' => 'CNI',
                        'ATTESTATION D\'IDENTITE' => 'ATTESTATION D\'IDENTITE',
                        'PASSPORT BIOMETRIQUE' => 'PASSPORT BIOMETRIQUE',
                        'PERMIS DE CONDUIRE' => 'PERMIS DE CONDUIRE',
                    ]
                ])
                ->add('codepostal', TextType::class, ['label' => 'Code Postal :', 'attr' => ['placeholder' => 'code postal']])
                ->add('numpiece', TextType::class, ['label' => 'N°Pièce :', 'attr' => ['placeholder' => 'N° Pièce ']])
                ->add('typehandicap', ChoiceType::class, [
                    'label' => 'Handicap ?:',
                    'choices' => [
                        'Non' => 'Non',
                        'Oui' => 'Oui',
                    ]
                ])
                ->add('cmu', TextType::class, [
                    'required' => false,
                    'constraints' => [
                        new RegEx("#^[0-9/? ?]{13,13}$#")
                    ],
                ])

                ->add('diplomeFilename', FileType::class, ['label' => 'Diplôme BEPC:','attr'=>['required'=>false]])
                ->add('certificatFilename', FileType::class, ['label' => 'Certificat de nationalité:','attr'=>['required'=>'false']])
                ->add('extraitFilename', FileType::class, ['label' => 'Extrait de naissance:'])
                ->add('cniFilename', FileType::class, ['label' => 'Pièce Verso*:', 'attr' => ['label' => 'CNI Recto', 'placeholder' => 'CNI verso ']])
                ->add('commune', EntityType::class, ['label' => 'Commune:',
                    'class' => Commune::class,
                    'choice_label' => function ($listecommune) {
                        return $listecommune->getLibelle();
                    }
                ])
                ->add('cniFilenamerecto', FileType::class, ['label' => 'Pièce Recto*:', 'attr' => ['placeholder' => 'CNI recto']])
                ->add('section', EntityType::class, ['label' => 'Section',
                    'class' => Section::class,
                    'choice_label' => function ($category) {
                        return $category->getLibelle();
                    }
                ])
                     ->add('agreeTerms', CheckboxType::class, [
                       'label' => 'Cliquer ici si vous acceptez le contrat',
                    'mapped' => false,
                    'constraints' => [
                        new IsTrue([
                            'message' => 'Vous devez accepter les termes du contrat de licence.',
                                ]),
                    ],
                ])
                ->add('plainPassword', PasswordType::class, [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'mapped' => false,
                    'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Confirmation'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrez un mot de passe SVP',
                                ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe est en d&eacute;ssous {{ limit }} caract &eacute;res',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                                ]),
                    ],
                ])
        ;
    }

//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//            'data_class' =>Inscription::class,
//        ]);
//    }
}
