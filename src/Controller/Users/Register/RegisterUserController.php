<?php

namespace App\Controller\Users\Register;

use App\Controller\BaseController;
use App\Envelope\DataEnvelope;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController extends BaseController
{
    public function __construct(private RegisterUserHandler $handler)
    {
    }

    #[Route('/users', name: 'register', methods: ["POST"])]
    public function index(Request $request): Response
    {
        $command = new RegisterUserCommand();
        $form = $this->createForm(RegisterUserType::class, $command);
        $form->handleRequest($request);

        $this->validate($form);

        $userId = $this->handler->handle($command);

        return $this->json(new DataEnvelope(
            new RegisterUserResponse($userId)
        ), 201);
    }
}
