<?php

declare(strict_types=1);

namespace App\Budget\Infrastructure\Controller;

use App\Application\Controller\AbstractController;
use App\Budget\Application\Command\CreateBudgetCommand;
use App\Budget\Infrastructure\Controller\BudgetController\BudgetCreated;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/budgets')]
#[IsGranted('ROLE_USER')]
class BudgetController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface   $bus,
        private readonly TokenStorageInterface $tokenStorage
    )
    {
    }

    #[Route('', name: 'budget_create', methods: ['POST'])]
    public function createBudget(Request $request): Response
    {
        $data = $request->toArray();
        $currentUser = $this->tokenStorage->getToken()?->getUser();

        $command = new CreateBudgetCommand($data['name'], $currentUser->getId());

        $this->bus->dispatch($command);

        // TODO: Создать View-модель BudgetCreated
        return $this->responseSerializer->successResponse(new BudgetCreated('Budget created successfully'), Response::HTTP_CREATED);
    }

    #[Route('/my', name: 'budget_get_my', methods: ['GET'])]
    public function getMyBudget(): Response
    {
        // TODO: Реализовать через Query Bus
        // 1. Создать GetMyBudgetQuery
        // 2. Создать GetMyBudgetHandler, который вернет DTO с данными бюджета
        // 3. $budgetDto = $this->bus->dispatch(new GetMyBudgetQuery());
        // 4. return $this->responseSerializer->successResponse($budgetDto);

        // Временный ответ-заглушка
        return $this->responseSerializer->successResponse(['message' => 'GET my budget endpoint']);
    }
}