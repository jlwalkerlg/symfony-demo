<?php

namespace App\Controller\Users\Register;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserCommand
{
    public ?string $name = null;
    public ?string $email = null;

    #[Assert\NotBlank]
    public ?string $password = null;
}
