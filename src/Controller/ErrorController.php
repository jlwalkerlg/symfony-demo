<?php

namespace App\Controller;

use App\Exception\RequestValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ErrorController extends AbstractController
{
    public function show(Throwable $exception): Response
    {
        if ($exception instanceof RequestValidationException) {
            return $this->json([
                'message' => $exception->getMessage(),
                'errors' => $exception->getErrors(),
            ], 422);
        }

        throw $exception;
    }
}
