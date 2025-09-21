<?php
declare(strict_types=1);

use Symfony\Config\FrameworkConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (FrameworkConfig $framework): void {
    $validator = $framework->validation();
    $validator->emailValidationMode('html5');

    if ('test' === param('kernel.environment')) {
        $validator->notCompromisedPassword()->enabled(false);
    }

    $profiler = $framework->profiler();

    if ('dev' === param('kernel.environment')) {
        $profiler->collectSerializerData(true);
    }

    if ('test' === param('kernel.environment')) {
        $profiler->collect(false);
    }
};