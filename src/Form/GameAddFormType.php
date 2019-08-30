<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class GameAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('retro_shape', IntegerType::class,[
                'label' => 'Retro ?',
                'required' => false
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description'
            ])
            ->add('stock', TextType::class, [
                'label' => 'Stock'
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix '
            ])
            ->add('platform', TextType::class, [
                'label' => 'Plateforme'
            ])
            ->add('pegi', TextType::class, [
                'label' => 'Pegi'
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'Photo'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
