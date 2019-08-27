<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StrongInteger extends Constraint
{
    private $min;
    private $max;
    private $acceptFloat;
    public $message_format = 'Le format de la "{{ value }}" est incorrecte.';
    public $message_size = 'La valeur "{{ value }}" n\'a pas la bonne taille.';

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

        if(!empty($options['acceptFloat'])){
            $this->acceptFloat = $options['acceptFloat'];
        }
        else{
            $this->acceptFloat = true;
        }
    }
}
