<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\StrongString;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',TextType::class,[
                'label' => 'Pseudo',
                'required' => false
            ])
            ->add('picture',TextType::class,[
                'label' => 'Image de profil',
                'required' => false
            ])
            ->add('mail',EmailType::class,[
                'label' => 'Votre Email',
                'required' => false
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Modifier mon profil"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
