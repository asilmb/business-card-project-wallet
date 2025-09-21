<?php

declare(strict_types=1);

use Symfony\Config\WebProfilerConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (WebProfilerConfig $profiler): void {
    if ('dev' === param('kernel.environment')) {
        $profiler->toolbar(true);
    }
};