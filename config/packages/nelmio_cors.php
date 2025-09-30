<?php
declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('nelmio_cors', [
        'paths' => [
            '^/api/' => [
                'allow_origin' => [],
                'allow_headers' => ['Content-Type', 'Authorization'],
                'allow_methods' => ['POST', 'GET', 'PUT', 'DELETE'],
                'max_age' => 3600,
                'origin_regex' => true,
            ],
        ],
    ]);
};