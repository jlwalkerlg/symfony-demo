<?php

namespace App\Controller\Users\Register;

use Symfony\Component\Uid\Uuid;

class RegisterUserResponse
{
    public function __construct(public Uuid $userId)
    {
    }
}
