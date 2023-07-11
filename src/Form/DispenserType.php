<?php

namespace App\Form;

use App\Entity\Classeroom;
use App\Entity\Dispenser;
use App\Entity\Enseignant;
use App\Entity\Matiere;
use App\Entity\Section;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DispenserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('brochureFilename', FileType::class, ['label' => 'Photo d\'identité :', 'attr' => ['placeholder' => 'Photo']])
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
                        return $enseignancs[$enseignanc->getId()] = $enseignanc->getNom() . '' . $enseignanc->getPrenom();
                    },
                ])
                ->add('classeroom', EntityType::class, [
                    'class' => Classeroom::class,
                    'required' => true,
                    'mapped' => true,
                    'attr' => array('class' => 'select2'),
                    'placeholder' => '--Choix classeroom --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                        // ->where('f.deletedAt IS NULL')
                        ->orderBy('f.libelle', 'DESC');
                    },
                    'choice_label' => function ($classeroom) {
                        return $classerooms[$classeroom->getId()] = $classeroom->getLibelle();
                    },
                ])
                ->add('matiere', EntityType::class, [
                    'class' => Matiere::class,
                    'required' => true,
                    'mapped' => true,
                    'attr' => array('class' => 'select2'),
                    'placeholder' => '--Choix matiere --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                        // ->where('f.deletedAt IS NULL')
                        ->orderBy('f.libelle', 'DESC');
                    },
                    'choice_label' => function ($matiere) {
                        return $matieres[$matiere->getId()] = $matiere->getLibelle();
                    },
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
                ->add('lesson', TextType::class, [
                    'required' => true,
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
            'data_class' => Dispenser::class,
        ]);
    }

}
