<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\StrongString;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('pseudo',TextType::class,[
                'label' => 'Choisissez un pseudo'
            ])
            ->add('pictureFile', FileType::class,[
                'label' => 'Image de profil',
                'required' => 'false'
            ])
            ->add('mail',EmailType::class,[
                'label' => 'Veuillez entrer votre email'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Choisissez votre mot de passe'],
                'second_options' => ['label' => 'Confirmation mot de passe']
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Envoyer"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
