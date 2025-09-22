<?php

declare(strict_types=1);

namespace App\Budget\Infrastructure\Controller;

use App\Application\Controller\AbstractController;
use App\Budget\Application\Command\AddAccountCommand;
use App\Budget\Infrastructure\Controller\AccountController\AccountAdded;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/budgets/{budgetId}/accounts')]
#[IsGranted('ROLE_USER')]
class AccountController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface   $bus,
    )
    {
    }

    #[Route('', name: 'account_add', methods: ['POST'])]
    public function addAccount(int $budgetId, Request $request): Response
    {
        $data = $request->toArray();

        $command = new AddAccountCommand(
            $budgetId,
            $data['name'],
            (int)$data['initialBalance'],
            $data['currency']
        );

        $this->bus->dispatch($command);

        return $this->responseSerializer->successResponse(new AccountAdded('Account added successfully'), Response::HTTP_CREATED);
    }

    #[Route('', name: 'account_list', methods: ['GET'])]
    public function listAccounts(int $budgetId): Response
    {
        // TODO: Реализовать через Query Bus
        // 1. Создать ListAccountsQuery($budgetId)
        // 2. Создать ListAccountsHandler, который вернет массив DTO с данными счетов
        // 3. $accountDtos = $this->bus->dispatch(new ListAccountsQuery($budgetId));
        // 4. return $this->responseSerializer->successListResponse($accountDtos);

        // Временный ответ-заглушка
        return $this->responseSerializer->successResponse(['message' => "List accounts for budget {$budgetId}"]);
    }
}