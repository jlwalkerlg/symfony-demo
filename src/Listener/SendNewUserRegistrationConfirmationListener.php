<?php

namespace App\Listener;

use App\Controller\Users\Register\UserRegisteredEvent;
use App\UnitOfWorkInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendNewUserRegistrationConfirmationListener implements MessageHandlerInterface
{
    public function __construct(
        private UnitOfWorkInterface $uow,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(UserRegisteredEvent $event)
    {
        $user = $this->uow->users()->findById($event->getUserId());

        if (!$user) throw new Exception("User not found with ID {$event->getUserId()}.");

        $this->logger->info("Sending confirmation email to {$user->getEmail()}.");
    }
}
