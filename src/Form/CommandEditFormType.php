<?php

namespace App\Form;

use App\Entity\Command;
use App\Form\CommandEditFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class CommandEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('user_command', TextType::class,[
                'label' => 'Pseudo'
            ])
            
            ->add('command_date', DateTimeType::class,[
                'label' => 'Jour de commande'
            ])
        
            ->add('status', TextType::class,[
                'label' => 'Status'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
