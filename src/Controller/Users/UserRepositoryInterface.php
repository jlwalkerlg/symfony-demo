<?php

namespace App\Controller\Users;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

interface UserRepositoryInterface
{
    public function add(User $user): void;
    public function findById(Uuid $id): ?User;
    public function findByEmail(string $email): ?User;
}
