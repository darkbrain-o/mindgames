<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StrongPasswordValidator extends ConstraintValidator
{
    private $min; //int
    private $max;  //int

    
    public function __construct(int $min = -999, int $max = -999)
    {
        $this->min = $min;
        $this->max = $max;
    }
    

    public function validate($value, Constraint $constraint)
    {
        //----------------   VERIF SI NULL   ----------------
        /* @var $constraint \App\Validator\StrongPassword */

        if (null === $value || '' === $value) {
            return;
        }

        //------------   VERIF CONTENU DANS LES MIN/MAX   ------------
        //Si on oblige un min et un max
        if ($this->min !== -999 && $this->max !== -999) {
            //Il doit être contenu dans les limites min/max (comprises)
            if (mb_strlen($value) < $this->min || mb_strlen($value) > $this->max) {
                $this->confirmStop($value, $constraint);
            }
        }

        //---------------   VERIF MOT DE PASSE   ---------------
        /*Vérifier si le mot de passe contient au moins :
            - 1 chiffre
            - 1 lettre majuscule
            - 1 lettre minuscule
            - 1 caractère spécial
        */
        if (!\preg_match('~[0-9]+~', $value) || 
        !\preg_match('~[A-Z]+~', $value)|| 
        !\preg_match('~[a-z]+~', $value)|| 
        !\preg_match('~[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]*]+~', $value)) {
            $this->confirmStop($value, $constraint);
        }
    }

    //Si il rentre dans les conditions, l'input est invalide
    private function confirmStop($value, Constraint $constraint)
    {
        //Créer la violation pour pouvoir lui send un flash error
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
