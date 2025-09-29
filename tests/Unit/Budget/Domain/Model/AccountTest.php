<?php

declare(strict_types=1);


namespace App\Tests\Unit\Budget\Domain\Model;

use App\Budget\Domain\Model\Account;
use App\Shared\Domain\ValueObject\Money;
use App\Tests\Resource\Access\TestBudget;
use App\Tests\UnitTestCase;

final class AccountTest extends UnitTestCase
{
    public function testAccount(): void {
        $budget = TestBudget::create();
        $initialBalance = 10;
        $name = 'testName';
        $initialBalance = Money::fromAmount($initialBalance, $budget->getCurrency());

        $account = new Account($budget, $name, $initialBalance);
        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals($name, $account->getName());
        $this->assertEquals($budget->getCurrency(), $account->getCurrency());
        $this->assertEquals($initialBalance->getAmount(), $account->getBalance());
    }
}
