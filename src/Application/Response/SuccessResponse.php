<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class SuccessResponse extends JsonResponse
{
    public function __construct(string $json, int $status)
    {
        parent::__construct(data: $json, status: $status, json: true);
    }
}
