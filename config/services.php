<?php
declare(strict_types=1);

use App\Application\Response\ResponseSerializer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();


    $services->load('App\\',  __DIR__ . '/../src/**/*{Entity}.php');
    $services->load('App\\', '../src/')
        ->exclude([
            '../src/DependencyInjection/',
            '../src/Kernel.php',
            '../src/Access/Fixtures/Test/',
        ]);

    $services->load('App\\Controller\\',  __DIR__ . '/../src/*{Controller}.php')
        ->tag('controller.service_arguments');

    $services->set(ResponseSerializer::class);
};