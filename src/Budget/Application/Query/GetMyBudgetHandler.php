<?php

declare(strict_types=1);


namespace App\Budget\Application\Query;

use App\Access\Domain\Model\User;
use App\Budget\Domain\Model\Budget;
use App\Budget\Domain\Repository\BudgetRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsMessageHandler(bus: 'query.bus')]
final class GetMyBudgetHandler
{
    public function __construct(
        private BudgetRepositoryInterface $budgetRepository,
        private TokenStorageInterface     $tokenStorage
    ) {
    }

    public function __invoke(GetMyBudgetQuery $command): ?Budget
    {
        $user = $this->tokenStorage->getToken()?->getUser();
        if (!$user instanceof User) {
            return null;
        }

        return $this->budgetRepository->findOneByUser($user);
    }
}
