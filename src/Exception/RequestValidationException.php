<?php

namespace App\Exception;

use Exception;

class RequestValidationException extends Exception
{
    public function __construct(private array $errors)
    {
        parent::__construct('The given data was invalid.');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
