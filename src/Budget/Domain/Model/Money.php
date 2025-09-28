<?php

declare(strict_types=1);


namespace App\Budget\Domain\Model;

use App\Budget\Domain\Exception\MoneyCreateException;
use App\Shared\Domain\ValueObject\Currency;

final class Money
{
    public const CREATE_EXCEPTION_MESSAGE = 'Amount cannot be negative.';

    /**
     * @param int $amount
     * @param Currency $currency
     */
    private function __construct(
        public int      $amount,
        public Currency $currency
    ) {
    }

    /**
     * @throws MoneyCreateException
     */
    public static function fromAmount(int $amount, Currency $currency): Money
    {
        if ($amount < 0) {
            throw new MoneyCreateException(self::CREATE_EXCEPTION_MESSAGE);
        }
        return new self($amount, $currency);
    }
}
