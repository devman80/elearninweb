<?php

namespace App\Form;

use App\Entity\Coefficiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CoefficiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libelle', TextType::class, [
            'required' => true,
            'constraints' => [
                new Regex([
                    'pattern' => '/^[0-9]{1,2}+$/',
                    'match' => true,
                    'message' => 'Veuillez saisir uniquement les chiffres de 1 ou 2 caractères',
                        ])
            ],
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coefficiant::class,
        ]);
    }
}
