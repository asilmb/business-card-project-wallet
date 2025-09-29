<?php
declare(strict_types=1);


namespace App\Tests\Resource\Access;

use App\Budget\Domain\Model\Budget;
use App\Shared\Domain\ValueObject\Currency;

final class TestBudget
{
    public static function create($name = '', $currency = Currency::EUR): Budget
    {
        return  Budget::create(TestUser::create(), $name, $currency);

    }
}