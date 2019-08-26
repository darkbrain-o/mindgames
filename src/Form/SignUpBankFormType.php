<?php

namespace App\Form;

use App\Entity\UserBank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpBankFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nb_card')
            ->add('date_exp')
            ->add('cryptogram')
            ->add('lastname')
            ->add('firstname')
            ->add('adress')
            ->add('postal_code')
            ->add('city')
            ->add('birthday_date')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserBank::class,
        ]);
    }
}
