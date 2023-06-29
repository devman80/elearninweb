<?php

namespace App\Form;

use App\Entity\Classeroom;
use App\Entity\Inscrire;
use App\Entity\Stagiaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscrireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateinscrire', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'required' => true,
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('classeroom', EntityType::class, [
                    'class' => Classeroom::class,
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                        ->where('f.deletedAt IS NULL')
                        ->orderBy('f.libelle', 'DESC');
                    },
                    'choice_label' => function ($classeroom) {
                        return $classerooms[$classeroom->getId()] = $classeroom->getLibelle();
                    },
                ])
            ->add('stagiaire', EntityType::class, [
                    'class' => Stagiaire::class,
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                        ->where('f.deletedAt IS NULL')
                        ->orderBy('f.nom', 'DESC');
                    },
                    'choice_label' => function ($stagiaire) {
                        return $stagiaires[$stagiaire->getId()] = $stagiaire->getNom() .''.$stagiaire->getPrenom();
                    },
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscrire::class,
        ]);
    }
}
