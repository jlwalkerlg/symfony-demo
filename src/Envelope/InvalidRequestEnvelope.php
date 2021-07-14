<?php

namespace App\Envelope;

class InvalidRequestEnvelope extends ErrorEnvelope
{
    public function __construct(public array $errors)
    {
        parent::__construct('The given data was invalid.');
    }
}
