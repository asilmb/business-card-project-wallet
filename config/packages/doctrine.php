<?php
declare(strict_types=1);

use Symfony\Config\DoctrineConfig;


return static function (DoctrineConfig $doctrine) {
    $dbal = $doctrine->dbal();
    $dbal->connection('default')
        ->url('%env(resolve:DATABASE_URL)%')
        ->useSavepoints(true);

    $orm = $doctrine->orm();
    $orm->autoGenerateProxyClasses(true);

    $em = $orm->entityManager('default');
    $em->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware');

    $em->mapping('Access')
        ->isBundle(false)
        ->dir('%kernel.project_dir%/src/Access/Domain/Model')
        ->prefix('App\Access\Domain\Model')
        ->alias('Access');
};