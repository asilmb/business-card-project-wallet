<?php

declare(strict_types=1);

namespace App\Budget\Domain\Repository;

use App\Access\Domain\Model\User;
use App\Budget\Domain\Model\Budget;

interface BudgetRepositoryInterface
{
    public function findOneByUser(User $user): ?Budget;

    public function save(Budget $budget): void;
}
