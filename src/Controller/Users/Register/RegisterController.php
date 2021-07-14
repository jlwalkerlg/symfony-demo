<?php

namespace App\Controller\Users\Register;

use App\Controller\BaseController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends BaseController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/users', name: 'register', methods: ["POST"])]
    public function index(Request $request): Response
    {
        $command = new RegisterCommand();
        $form = $this->createForm(RegisterType::class, $command);
        $form->handleRequest($request);

        $this->validate($form);

        $user = new User(
            $command->name,
            $command->email,
            password_hash($command->password, PASSWORD_DEFAULT)
        );

        $this->em->persist($user);
        $this->em->flush();

        return $this->json($command, 201);
    }
}
