<?php
declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('doctrine_fixtures', [
        'paths' =>
            [
                'App\Access\Fixtures\Test' => '%kernel.project_dir%/src/Access/Fixtures/Test',
            ]
    ]);
    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\Access\\Fixtures\\Test\\', '%kernel.project_dir%/src/Access/Fixtures/Test/')
        ->tag('doctrine.fixture.orm');
};