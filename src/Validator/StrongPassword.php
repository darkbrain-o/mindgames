<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StrongPassword extends Constraint
{
    public $min;
    public $max;
    public $message_size = 'La valeur "{{ value }}" n\'a pas la bonne taille.';
    public $message_specialChar = 'La valeur "{{ value }}" n\'a pas le bon format.';

    public function __construct($options)
    {
        if(!empty($options['min'])){
            $this->min = $options['min'];
        }
        else{
            $this->min = -999;
        }

        if(!empty($options['max'])){
            $this->max = $options['max'];
        }
        else{
            $this->max = -999;
        }
    }
}

