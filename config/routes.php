<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->import('routes/security.php');

    $routes->import('../src/*{Controller}.php', 'attribute');
};