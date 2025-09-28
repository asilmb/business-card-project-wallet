<?php

declare(strict_types=1);


namespace App\Access\Domain\Repository;

use App\Access\Domain\Model\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function save(User $user): void;
}
