<?php

declare(strict_types=1);


namespace App\Tests\Unit\Budget\Domain\Model;

use App\Budget\Domain\Model\Budget;
use App\Shared\Domain\ValueObject\Currency;
use App\Tests\Resource\Access\TestUser;
use App\Tests\UnitTestCase;

final class BudgetTest extends UnitTestCase
{
    public function testBudget(): void {
        $name = 'testName';
        $currency = Currency::EUR;
        $budget = Budget::create(TestUser::create(), $name, $currency);
        $this->assertInstanceOf(Budget::class, $budget);
        $this->assertEquals($name, $budget->getName());
        $this->assertEquals($currency, $budget->getCurrency());
    }
}
