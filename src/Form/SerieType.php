<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('resume')
            ->add('duree')
            ->add('premiereDiffusion')
            ->add('image')
            ->add('video')
            ->add('nbEpisodes')
            ->add('sauvegarder', SubmitType::class, [
                'attr' => [
                    'class' => 'sauvegarder'
                ],
            ])
            #->add('lesGenres')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
