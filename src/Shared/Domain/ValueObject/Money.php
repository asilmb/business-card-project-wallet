<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Budget\Domain\Exception\MoneyCreateException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Money
{
    public const CREATE_EXCEPTION_MESSAGE = 'Amount cannot be negative.';

    #[ORM\Column(type: 'integer')]
    private int $amount;

    #[ORM\Column(length: 3, enumType: Currency::class)]
    private Currency $currency;

    public function __construct(int $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @throws MoneyCreateException
     */
    public static function fromAmount(int $amount, Currency $currency): self
    {
        if ($amount < 0) {
            throw new MoneyCreateException(self::CREATE_EXCEPTION_MESSAGE);
        }

        return new self($amount, $currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}