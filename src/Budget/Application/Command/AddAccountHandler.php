<?php

declare(strict_types=1);

namespace App\Budget\Application\Command;

use App\Budget\Application\Exception\AddAccountException;
use App\Budget\Domain\Model\Budget;
use App\Budget\Domain\Model\Money;
use App\Budget\Domain\Repository\BudgetRepositoryInterface;
use App\Shared\Domain\ValueObject\Currency;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsMessageHandler]
final readonly class AddAccountHandler
{
    public function __construct(
        private BudgetRepositoryInterface $budgetRepository,
        private TokenStorageInterface $tokenStorage
    ) {}

    /**
     * @throws AddAccountException
     */
    public function __invoke(AddAccountCommand $command): void
    {
        /** @var Budget $budget */
        $budget = $this->budgetRepository->find($command->budgetId);

        if (!$budget) {
            throw new AddAccountException('Budget not found');
        }

        $currentUser = $this->tokenStorage->getToken()?->getUser();
        if ($budget->getOwner() !== $currentUser) {
            throw new AddAccountException('You are not the owner of this budget.');
        }

        $currency = Currency::from($command->currency);
        $initialBalance = Money::fromAmount($command->initialBalanceAmount, $currency);

        $budget->addAccount($command->name, $initialBalance);

        $this->budgetRepository->save($budget);
    }
}