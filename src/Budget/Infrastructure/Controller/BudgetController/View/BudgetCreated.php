<?php
declare(strict_types=1);


namespace App\Budget\Infrastructure\Controller\BudgetController\View;

final class BudgetCreated
{
    public function __construct(public readonly string $message)
    {
    }
}