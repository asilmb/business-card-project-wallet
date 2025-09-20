<?php
declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
    $framework->cache()
        ->prefixSeed('bussiness-card');

    $framework->secret('%env(APP_SECRET)%');
    $framework->httpMethodOverride(false);

    $framework->session()
        ->handlerId(null)
        ->cookieSecure('auto')
        ->cookieSamesite('lax')
        ->storageFactoryId('session.storage.factory.native');
};