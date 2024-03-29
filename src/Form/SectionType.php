<?php

namespace App\Form;

use App\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libelle')
        ->add('scolarite')
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
            'data_class' => Section::class,
        ]);
    }
}
