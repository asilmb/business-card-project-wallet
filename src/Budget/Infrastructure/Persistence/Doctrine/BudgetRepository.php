<?php

declare(strict_types=1);

namespace App\Budget\Infrastructure\Persistence\Doctrine;

use App\Access\Domain\Model\User;
use App\Budget\Domain\Model\Budget;
use App\Budget\Domain\Repository\BudgetRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Budget>
 */
class BudgetRepository extends ServiceEntityRepository implements BudgetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Budget::class);
    }

    public function findOneByUser(User $user): ?Budget
    {
        return $this->findOneBy(['owner' => $user]);
    }

    public function save(Budget $budget): void
    {
        $this->getEntityManager()->persist($budget);
        $this->getEntityManager()->flush();
    }
}
