<?php
declare(strict_types=1);

use Symfony\Config\LexikJwtAuthenticationConfig;

return static function (LexikJwtAuthenticationConfig $config): void {
    $config->secretKey('%env(resolve:JWT_SECRET_KEY)%');
    $config->publicKey('%env(resolve:JWT_PUBLIC_KEY)%');
    $config->passPhrase('%env(JWT_PASSPHRASE)%');
    $config->tokenTtl(3600);
};