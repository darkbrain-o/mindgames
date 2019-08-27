<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\StrongString;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


class ProfilFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('pseudo',TextType::class,[
                'label' => 'Pseudo',
                'required' => false
            ])
            // ->add('pictureFile',FileType::class,[
            //     'label' => 'Image de profil',
            //     'required' => false
            // ]) 
            // ->add('pictureFile', textType::class, [
            //     'required' => false
            // ])
            ->add('mail',EmailType::class,[
                'label' => 'Votre Email',
                'required' => false
            ])
/*             ->add('password',PasswordType::class,[
                'label' => 'Mot de passe',
                'required' => false
            ]) */
            
/*             ->add('oldpassword',PasswordType::class,[
                'label' => 'Confirmer votre ancien mot de passe : ',
                'mapped' => false,
                'constraints' => [
                    new UserPassword()
                ],
                'required' => true
            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Choisissez votre mot de passe'],
                'second_options' => ['label' => 'Confirmation mot de passe'],
                'mapped' => false
            ]) */

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
