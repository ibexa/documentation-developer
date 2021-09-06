<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class AlphaOnly extends Constraint
{
    public $message = 'The attribute can only contain letters or numbers.';
}
