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

    // public function __construct($options)
    // {
    //     if (!isset($options["min"])) {
    //         $this->min = -999;
    //     } else {
    //         $this->min = $options["min"];
    //     }
    //     if (!isset($options["max"])) {
    //         $this->max = -999;
    //     } else {
    //         $this->max = $options["max"];
    //     }
    //     if (!isset($options["allowSpecialChars"])) {
    //         $this->allowSpecialChars = false;
    //     } else {
    //         $this->allowSpecialChars = $options["allowSpecialChars"];
    //     }
    // }

    public function getItem()
    {
        // return \get_class($this) . 'Validator';
        return $this;
    }
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid.';
}
