<?php

declare(strict_types=1);

namespace App\Tests;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

class E2ETestKernel extends Kernel
{
    use MicroKernelTrait;
}