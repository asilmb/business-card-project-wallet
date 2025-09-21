<?php

declare(strict_types=1);

use Symfony\Config\TwigConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (TwigConfig $twig): void {
    $twig->fileNamePattern('*.twig');

    if ('test' === param('kernel.environment')) {
        $twig->strictVariables(true);
    }
};