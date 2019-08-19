<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('retro_shape')
            ->add('description')
            ->add('name')
            ->add('stock')
            ->add('status')
            ->add('price')
            ->add('creation_date')
            ->add('platform')
            ->add('pegi')
            ->add('picture')
            ->add('command')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
