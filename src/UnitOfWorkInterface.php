<?php

namespace App;

use App\Controller\Users\UserRepositoryInterface;

interface UnitOfWorkInterface
{
    public function users(): UserRepositoryInterface;
    public function dispatch(EventInterface $event): void;
    public function commit(): void;
}
