<?php

namespace App\Controller;

use App\Envelope\ErrorEnvelope;
use App\Envelope\InvalidRequestEnvelope;
use App\Exception\RequestValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ErrorController extends AbstractController
{
    public function show(Throwable $exception): Response
    {
        if ($exception instanceof RequestValidationException) {
            return $this->json(
                new InvalidRequestEnvelope($exception->getErrors()),
                422
            );
        }

        return $this->json(new ErrorEnvelope($exception->getMessage()), 500);
        return $this->json(new ErrorEnvelope('Internal server error.'), 500);
    }
}
