<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Genre;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
            ->add('lesGenres', EntityType::class, array(
                'class' => Genre::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('genre')
                        ->orderBy('genre.libelleGenre', 'ASC');
                },
                'choice_label' => 'libelleGenre',
                'multiple' => true,
                'expanded' => true
            ))
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
