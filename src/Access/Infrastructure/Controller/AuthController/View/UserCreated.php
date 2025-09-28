<?php
declare(strict_types=1);


namespace App\Access\Infrastructure\Controller\AuthController\View;

final class UserCreated
{
    public function __construct(public readonly string $message)
    {
    }
}