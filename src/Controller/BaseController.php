<?php

namespace App\Controller;

use App\Exception\RequestValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class BaseController extends AbstractController
{
    protected function validate(FormInterface $form): void
    {
        if ($form->isValid()) return;

        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }

        throw new RequestValidationException($errors);
    }
}
