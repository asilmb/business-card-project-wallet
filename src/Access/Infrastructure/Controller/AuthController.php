<?php
declare(strict_types=1);


namespace App\Access\Infrastructure\Controller;

use App\Access\Application\Command\RegisterUserCommand;
use App\Access\Infrastructure\Controller\AuthController\UserCreated;
use App\Application\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth', name: 'api_auth_')]
final class AuthController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $data = $request->toArray();

        $command = new RegisterUserCommand(
            $data['email'],
            $data['password']
        );
        $this->bus->dispatch($command);

        return $this->responseSerializer->successResponse(new UserCreated('User registered successfully'), Response::HTTP_CREATED);
    }
}