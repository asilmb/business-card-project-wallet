<?php

declare(strict_types=1);

namespace App\Budget\Application\Command;

final class CreateBudgetCommand
{
    public function __construct(
        public string $name,
        public string $currency
    ) {}
}