<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StrongStringValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
         //----------------   VERIF SI NULL   ----------------
        /* @var $constraint \App\Validator\StrongString */

        if (null === $value || '' === $value) {
            return;
        }

        //------------   VERIF SI c'est une string   ------------
        //Vérifier sans caractères spéciaux

        if(!$constraint->allowSpecialChars){
            //N'accepte que les lettres et majuscules
            if (!\preg_match('~^[a-zA-Z]+$~', $value)) {
                $this->confirmStop($value,$constraint->message_character);
            }
        }
        //Vérifier avec caractères spéciaux
        else{
            if (!\preg_match('~^[a-zA-Z!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]*$~', $value)) {
                $this->confirmStop($value,$constraint->message_character);
            }
        }

        //------------   VERIF CONTENU DANS LES MIN/MAX   ------------
        //Si on oblige un min et un max
        if ($constraint->min !== -999 && $constraint->max !== -999) {
            //Il doit être contenu dans les limites min/max (comprises)
            if (mb_strlen($value) < $constraint->min || mb_strlen($value) > $constraint->max) {
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
