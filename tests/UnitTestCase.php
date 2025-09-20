<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    final protected static function getKernelClass(): string
    {
        return UnitTestKernel::class;
    }
}
