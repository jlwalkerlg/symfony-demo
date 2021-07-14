<?php

namespace App\Envelope;

class ErrorEnvelope
{
    public function __construct(public string $message)
    {
    }
}
