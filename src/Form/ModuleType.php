<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Matiere;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
   
        ->add('volumeheure')
        ->add('libelle')
        ->add('matiere', EntityType::class, [
            'class' => Matiere::class,
            'required' => true,
            'mapped' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('f')
             //   ->where('f.deletedAt IS NULL')
                ->orderBy('f.libelle', 'DESC');
            },
            'choice_label' => function ($matiere) {
                return $matieres[$matiere->getId()] = $matiere->getLibelle();
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
