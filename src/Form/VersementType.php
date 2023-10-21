<?php

namespace App\Form;

use App\Entity\Section;
use App\Entity\Versement;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersementType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('montantversement')
                ->add('code')
                ->add('dateversement', DateType::class, [
                    // renders it as a single text box
                    'widget' => 'single_text',
                    'required' => true,
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('section', EntityType::class, [
                    'class' => Section::class,
                    'required' => true,
                    'mapped' => true,
                    'attr' => array('class' => 'select2'),
                    'placeholder' => '--Choix section --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                        // ->where('f.deletedAt IS NULL')
                        ->orderBy('f.libelle', 'DESC');
                    },
                    'choice_label' => function ($matiere) {
                        return $matieres[$matiere->getId()] = $matiere->getLibelle();
                    },
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
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Versement::class,
        ]);
    }

}
