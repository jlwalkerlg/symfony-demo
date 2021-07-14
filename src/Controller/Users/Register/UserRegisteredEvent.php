<?php

namespace App\Controller\Users\Register;

use App\EventInterface;
use Symfony\Component\Uid\Uuid;

class UserRegisteredEvent implements EventInterface
{
    public function __construct(private Uuid $userId)
    {
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }
}
