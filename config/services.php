<?php
declare(strict_types=1);

use App\Application\Controller\AbstractController;
use App\Application\Response\ResponseSerializer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', '../src/')
        ->exclude([
            '../src/DependencyInjection/',
            '../src/Kernel.php',
            '../src/*/Domain/Model/',
        ]);

    $services->set(ResponseSerializer::class);
    $services->instanceof(AbstractController::class)
        ->tag('controller.service_arguments');
};