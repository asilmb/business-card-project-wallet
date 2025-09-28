<?php

declare(strict_types=1);

namespace App\Budget\Application\Command;

use App\Access\Domain\Model\User;
use App\Budget\Application\Exception\AddAccountException;
use App\Budget\Application\Exception\CreateBudgetException;
use App\Budget\Domain\Model\Money;
use App\Budget\Domain\Repository\BudgetRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class AddAccountHandler
{
    public function __construct(
        private BudgetRepositoryInterface $budgetRepository,
        private TokenStorageInterface     $tokenStorage
    ) {
    }

    /**
     * @throws AddAccountException
     */
    public function __invoke(AddAccountCommand $command): void
    {
        $user = $this->tokenStorage->getToken()?->getUser();
        if (!$user instanceof User) {
            throw new CreateBudgetException('User must be authenticated to create a budget.');
        }

        $budget = $this->budgetRepository->findOneByUser($user);

        if (!$budget) {
            throw new AddAccountException('Budget not found');
        }

        $initialBalance = Money::fromAmount($command->initialBalanceAmount, $budget->getCurrency());

        $budget->addAccount($command->name, $initialBalance);

        $this->budgetRepository->save($budget);
    }
}
