<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class StrongStringValidator extends ConstraintValidator
{
    // private $entityManager;

    // public function __construct($options)
    // {
    //     $this->entityManager = $options;
    // }
    public $min;
    public $max;
    public $allowSpecialChars;
    
    public function validate($value, Constraint $constraint)
    {
        $this->allowSpecialChars = $constraint->getItem()->allowSpecialChars;
        $this->min = $constraint->getItem()->min;
        $this->max = $constraint->getItem()->max;

         //----------------   VERIF SI NULL   ----------------
        /* @var $constraint \App\Validator\StrongString */

        if (null === $value || '' === $value) {
            return;
        }

        //------------   VERIF SI c'est une string   ------------
        //Vérifier sans caractères spéciaux
        if(!$this->allowSpecialChars){
            //N'accepte que les lettres et majuscules
            if (!\preg_match('~^[a-zA-Z]+$~', $value)) {
                $this->confirmStop($value, $constraint);
            }
        }
        //Vérifier avec caractères spéciaux
        else{
            if (!\preg_match('~^[a-zA-Z!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]*$~', $value)) {
                $this->confirmStop($value, $constraint);
            }
        }

        //------------   VERIF CONTENU DANS LES MIN/MAX   ------------
        //Si on oblige un min et un max
        if ($this->min !== -999 && $this->max !== -999) {
            //Il doit être contenu dans les limites min/max (comprises)
            if (mb_strlen($value) < $this->min || mb_strlen($value) > $this->max) {
                $this->confirmStop($value, $constraint);
            }
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
