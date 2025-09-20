<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\HttpKernel\KernelInterface;

class UnitTestKernel extends BaseKernel implements KernelInterface
{
    use MicroKernelTrait;

}
