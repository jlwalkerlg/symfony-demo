<?php

namespace App\Controller\Users\Register;

use App\Entity\User;
use App\Exception\RequestValidationException;
use App\Services\Hashing\PasswordHasherInterface;
use App\UnitOfWorkInterface;
use Symfony\Component\Uid\Uuid;

class RegisterUserHandler
{
    public function __construct(
        private UnitOfWorkInterface $uow,
        private PasswordHasherInterface $passwordHasher
    ) {
    }

    public function handle(RegisterUserCommand $command): Uuid
    {
        $user = $this->uow->users()->findByEmail($command->email);

        if ($user !== null) {
            throw new RequestValidationException([
                'email' => 'This email address is already taken.',
            ]);
        }

        $user = new User(
            Uuid::v4(),
            $command->name,
            $command->email,
            $this->passwordHasher->hash($command->password),
            $command->age
        );

        $this->uow->users()->add($user);
        $this->uow->dispatch(new UserRegisteredEvent($user->getId()));

        $this->uow->commit();

        return $user->getId();
    }
}
