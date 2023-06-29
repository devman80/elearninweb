<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class,)
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
        ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices' => [

                    'Administrateur' => 'ROLE_ADMIN',
                    'Secretaire' => 'ROLE_SECRETAIRE',
                    'Etudiant' => 'ROLE_ETUDIANT',
                    'Enseignant' => 'ROLE_ENSEIGNANT',
                    'Tresorier' => 'ROLE_TRESORIER',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation mot de passe'],
                'invalid_message' => 'Les champs mot de passe doivent être identiques',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Mot de passe doit comporter 4 caractères au moins',
                            ]),
                ],
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

            ->add('save', SubmitType::class, [
                'attr' => [
                    'value' => 'create'
                ]
            ])
            ->add('saveAndAdd', SubmitType::class, [
                'attr' => [
                    'value' => 'save-and-add'
                ]
            ])
        ;

        $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
                        function ($rolesArray) {
// transform the array to a string
                            return count($rolesArray) ? $rolesArray[0] : null;
                        },
                        function ($rolesString) {
// transform the string back to an array
                            return [$rolesString];
                        }
));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'error_mapping' => [
                'matchingCityAndZipCode' => 'city',
            ],
        ]);
    }

    
    
}
