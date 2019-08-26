<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StrongString extends Constraint
{
    public $min;
    public $max;
    public $allowSpecialChars;
    public $message_size = 'La valeur "{{ value }}" ne contient pas le bon nombre de caractères.';
    public $message_character = 'La valeur "{{ value }}" n\' pas le bon format.';


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

        if(!empty($options['allowSpecialChars'])){
            $this->allowSpecialChars = $options['allowSpecialChars'];
        }
        else{
            $this->allowSpecialChars = false;
        }
    }
}
