<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

enum Currency: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case RUB = 'RUB';

    public function symbol(): string
    {
        return match ($this) {
            self::USD => '$',
            self::EUR => '€',
            self::RUB => '₽',
        };
    }
}
