<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $messenger = $framework->messenger();

    $commandBus = $messenger->bus('command.bus');
    $commandBus->middleware()->id('validation');
    $commandBus->middleware()->id('doctrine_transaction');

    $queryBus = $messenger->bus('query.bus');
    $queryBus->middleware()->id('validation');

    $messenger->defaultBus('command.bus');
};