<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StrongIntegerValidator extends ConstraintValidator
{
    
    public function validate($value, Constraint $constraint)
    {
        //----------------   VERIF SI NULL   ----------------
        /* @var $constraint \App\Validator\StrongInteger */

        if (null === $value || '' === $value) {
            return;
        }

        //----------------   VERIF INT OR FLOAT   ----------------
        //Si il n'est pas autorisé à être un float

        if (!$constraint->acceptFloat) {
            //Il ne doit contenir que des chiffres du début à la fin
            if (!\preg_match('~^[0-9]+$~', $value)) {
                $this->confirmStop($value, $constraint->message_format);

            }
        }
        //Si il peut être un float
        else {
            //Il ne doit contenir que des chiffres du début jusqu'à la fin. Il accepte une virgule mais pas en dernière position
            if (!\preg_match('~^[0-9]+,?[0-9]{0,2}$~', $value) 
            || \preg_match('~,$~', $value)) {

                $this->confirmStop($value, $constraint->message_format);
            }
        }


        //------------   VERIF CONTENU DANS LES MIN/MAX   ------------
        //Si on oblige un min et un max

        if ($constraint->min !== -999 && $constraint->max !== -999) {
            //Il doit être contenu dans les limites min/max (comprises)
            if ($value < $constraint->min || $value > $constraint->max) {
                $this->confirmStop($value, $constraint->message_size);
            }
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
