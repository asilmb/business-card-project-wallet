<?php

declare(strict_types=1);


namespace App\Tests\Unit\Budget\Domain\Model;

use App\Budget\Domain\Exception\MoneyCreateException;
use App\Budget\Domain\Model\Money;
use App\Shared\Domain\ValueObject\Currency;
use App\Tests\UnitTestCase;

final class MoneyTest extends UnitTestCase
{
    public function testCreateMoney(): void
    {
        $expectedAmount = 10.10;
        $expectedCurrency = Currency::EUR;

        $money = Money::fromAmount($expectedAmount, $expectedCurrency);
        self::assertInstanceOf(Money::class, $money);
        self::assertEquals($expectedAmount, $money->amount);
        self::assertEquals($expectedCurrency, $money->currency);
    }

    public function testCreateMoneyFailed(): void
    {
        $expectedAmount = -10.10;
        $expectedCurrency = Currency::EUR;
        $this->expectException(MoneyCreateException::class);
        $this->expectExceptionMessage(Money::CREATE_EXCEPTION_MESSAGE);
        Money::fromAmount($expectedAmount, $expectedCurrency);
    }
}
