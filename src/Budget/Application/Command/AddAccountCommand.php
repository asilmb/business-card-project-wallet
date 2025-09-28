<?php

declare(strict_types=1);


namespace App\Budget\Application\Command;

final readonly class AddAccountCommand
{
    public function __construct(
        public string $name,
        public int    $initialBalanceAmount
    ) {
    }
}
