<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class E2EWebTestCase extends WebTestCase
{
    final protected static function getKernelClass(): string
    {
        return E2ETestKernel::class;
    }
}
