<?php
declare(strict_types=1);


namespace App\Budget\Infrastructure\Controller\AccountController\View;

final class AccountAdded
{
    public function __construct(public readonly string $message)
    {
    }
}