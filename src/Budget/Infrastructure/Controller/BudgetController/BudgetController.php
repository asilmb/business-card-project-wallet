<?php

declare(strict_types=1);

namespace App\Budget\Infrastructure\Controller\BudgetController;

use App\Application\Controller\AbstractController;
use App\Budget\Application\Command\CreateBudgetCommand;
use App\Budget\Application\Query\GetMyBudgetQuery;
use App\Budget\Domain\Model\Budget;
use App\Budget\Infrastructure\Controller\BudgetController\View\BudgetCreated;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/budget')]
#[IsGranted('ROLE_USER')]
class BudgetController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private readonly MessageBusInterface $commandBus,
        MessageBusInterface                  $queryBus,
    ) {
        $this->messageBus = $queryBus;
    }

    #[Route('', name: 'budget_create', methods: ['POST'])]
    public function createBudget(Request $request): Response
    {
        $data = $request->toArray();

        $command = new CreateBudgetCommand($data['name'], $data['currency']);

        $this->commandBus->dispatch($command);

        return $this->responseSerializer->successResponse(new BudgetCreated('Budget created successfully'), Response::HTTP_CREATED);
    }

    #[Route('', name: 'budget_get_my', methods: ['GET'])]
    public function getMyBudget(): Response
    {
        $query = new GetMyBudgetQuery();

        $budget = $this->handle($query);

        if (null === $budget) {
            return $this->responseSerializer->errorResponse('Budget not found for the current user.', Response::HTTP_NOT_FOUND);
        }
        /** @var Budget $budget */
        return $this->responseSerializer->successResponse($budget);
    }
}
