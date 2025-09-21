<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class SuccessEmptyResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct([]);
    }
}
