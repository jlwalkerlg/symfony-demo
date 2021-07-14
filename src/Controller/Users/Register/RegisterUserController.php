<?php

namespace App\Controller\Users\Register;

use App\Controller\BaseController;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController extends BaseController
{
    public function __construct(
        private RegisterUserHandler $handler,
        private LoggerInterface $logger,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('/users', name: 'register', methods: ["POST"])]
    public function index(Request $request): Response
    {
        $command = new RegisterUserCommand();
        $form = $this->createForm(RegisterUserType::class, $command);
        $form->handleRequest($request);

        $this->validate($form);

        $userId = $this->handler->handle($command);

        return $this->json($userId, 201);
    }
}
