<?php

declare(strict_types=1);

namespace App\Budget\Infrastructure\Controller\AccountController;

use App\Application\Controller\AbstractController;
use App\Budget\Application\Command\AddAccountCommand;
use App\Budget\Infrastructure\Controller\AccountController\View\AccountAdded;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/budget/account')]
#[IsGranted('ROLE_USER')]
class AccountController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    #[Route('', name: 'account_add', methods: ['POST'])]
    public function addAccount(Request $request): Response
    {
        $data = $request->toArray();

        $command = new AddAccountCommand(
            $data['name'],
            (int)$data['initialBalance']
        );

        $this->commandBus->dispatch($command);

        return $this->responseSerializer->successResponse(new AccountAdded('Account added successfully'), Response::HTTP_CREATED);
    }
}
