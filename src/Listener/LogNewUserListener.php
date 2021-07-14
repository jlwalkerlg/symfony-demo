<?php

namespace App\Listener;

use App\Controller\Users\Register\UserRegisteredEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogNewUserListener implements MessageHandlerInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(UserRegisteredEvent $event)
    {
        $this->logger->info("New user registered with ID {$event->getUserId()}.");
    }
}
