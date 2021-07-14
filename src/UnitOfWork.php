<?php

namespace App;

use App\Controller\Users\DoctrineUserRepository;
use App\Controller\Users\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UnitOfWork implements UnitOfWorkInterface
{
    private array $events = [];

    private DoctrineUserRepository $userRepository;

    public function __construct(
        private EntityManagerInterface $em,
        private MessageBusInterface $bus
    ) {
    }

    public function users(): UserRepositoryInterface
    {
        return $this->userRepository ??= new DoctrineUserRepository($this->em);
    }

    public function dispatch(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    public function commit(): void
    {
        if (count($this->events) === 0) {
            $this->em->flush();
            return;
        }

        $this->em->beginTransaction();

        $this->em->flush();

        foreach ($this->events as $event) {
            $this->bus->dispatch($event);
        }

        $this->em->commit();
    }
}
