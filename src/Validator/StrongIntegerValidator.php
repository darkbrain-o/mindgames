<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StrongIntegerValidator extends ConstraintValidator
{
    private $min; //int
    private $max;  //int
    private $acceptFloat;//bool

    
    public function __construct(int $min = -999, int $max = -999, bool $acceptFloat = false)
    {
        $this->min = $min;
        $this->max = $max;
        $this->acceptFloat = $acceptFloat;
    }
    
    public function validate($value, Constraint $constraint)
    {
        //----------------   VERIF SI NULL   ----------------
        /* @var $constraint \App\Validator\StrongInteger */

        if (null === $value || '' === $value) {
            return;
        }

        //----------------   VERIF INT OR FLOAT   ----------------
        //Si il n'est pas autorisé à être un float
        if (!$this->acceptFloat) {
            //Il ne doit contenir que des chiffres du début à la fin
            if (!\preg_match('~^[0-9]+$~', $value)) {
                $this->confirmStop($value, $constraint);
            }
        }
        //Si il peut être un float
        else {
            //Il ne doit contenir que des chiffres du début jusqu'à la fin. Il accepte une virgule mais pas en dernière position
            if (!\preg_match('~^[0-9]+,?[0-9]{0,2}$~', $value) 
            || \preg_match('~,$~', $value)) {
                $this->confirmStop($value, $constraint);
            }
        }


        //------------   VERIF CONTENU DANS LES MIN/MAX   ------------
        //Si on oblige un min et un max
        if ($this->min !== -999 && $this->max !== -999) {
            //Il doit être contenu dans les limites min/max (comprises)
            if ($value < $this->min || $value > $this->max) {
                $this->confirmStop($value, $constraint);
            }
        }
    }
}
