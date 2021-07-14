<?php

namespace App\Controller\Users\Register;

use App\Controller\BaseController;
use App\Envelope\DataEnvelope;
use App\Services\ParamConverters\FromBody;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController extends BaseController
{
    public function __construct(private RegisterUserHandler $handler)
    {
    }

    #[Route('/users', name: 'register', methods: ["POST"])]
    #[FromBody('command', RegisterUserType::class)]
    public function index(RegisterUserCommand $command): Response
    {
        $userId = $this->handler->handle($command);

        return $this->json(new DataEnvelope(
            new RegisterUserResponse($userId)
        ), 201);
    }
}
