<?php

namespace App\Controller\Users\Register;

use App\Entity\User;
use App\UnitOfWorkInterface;
use Symfony\Component\Uid\Uuid;

class RegisterUserHandler
{
    public function __construct(private UnitOfWorkInterface $uow)
    {
    }

    public function handle(RegisterUserCommand $command): Uuid
    {
        $user = new User(
            Uuid::v4(),
            $command->name,
            $command->email,
            password_hash($command->password, PASSWORD_DEFAULT)
        );

        $this->uow->users()->add($user);
        $this->uow->dispatch(new UserRegisteredEvent($user->getId()));

        $this->uow->commit();

        return $user->getId();
    }
}
