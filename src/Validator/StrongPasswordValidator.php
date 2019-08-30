<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StrongPasswordValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        //----------------   VERIF SI NULL   ----------------
        /* @var $constraint \App\Validator\StrongPassword */

        if (null === $value || '' === $value) {
            return;
        }

        //------------   VERIF CONTENU DANS LES MIN/MAX   ------------
        //Si on oblige un min et un max

        if ($constraint->min !== -999 && $constraint->max !== -999) {
            //Il doit être contenu dans les limites min/max (comprises)
            if (mb_strlen($value) < $constraint->min || mb_strlen($value) > $constraint->max) {
                $this->confirmStop($value, $constraint->message_size);
            }
        }

        //---------------   VERIF MOT DE PASSE   ---------------

        /* Vérifier si le mot de passe contient au moins :
            - 1 chiffre
            - 1 lettre majuscule
            - 1 lettre minuscule
            - 1 caractère spécial
        */
        if (!\preg_match('~[0-9]+~', $value) || 
        !\preg_match('~[A-Z]+~', $value)|| 
        !\preg_match('~[a-z]+~', $value)|| 

        !\preg_match('~[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?\]*]+~', $value)) {
            $this->confirmStop($value, $constraint->message_specialChar);
        }
    }

    //Si il rentre dans les conditions, l'input est invalide

    private function confirmStop($value, string $message)
    {
        //Créer la violation pour pouvoir lui send un flash error
        $this->context->buildViolation($message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
