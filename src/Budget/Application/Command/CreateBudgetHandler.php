<?php

declare(strict_types=1);

namespace App\Budget\Application\Command;

use App\Access\Domain\Model\User;
use App\Budget\Application\Exception\CreateBudgetException;
use App\Budget\Domain\Model\Budget;
use App\Budget\Domain\Repository\BudgetRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsMessageHandler]
final class CreateBudgetHandler
{
    public function __construct(
        private BudgetRepositoryInterface $budgetRepository,
        private TokenStorageInterface $tokenStorage
    ) {}

    /**
     * @throws CreateBudgetException
     */
    public function __invoke(CreateBudgetCommand $command): void
    {
        $user = $this->tokenStorage->getToken()?->getUser();
        if (!$user instanceof User) {
            throw new CreateBudgetException('User must be authenticated to create a budget.');
        }

        if (null !== $this->budgetRepository->findOneByUser($user)) {
            throw new CreateBudgetException('User already has a budget.');
        }

        $budget = new Budget($user, $command->name);
        $this->budgetRepository->save($budget);
    }
}