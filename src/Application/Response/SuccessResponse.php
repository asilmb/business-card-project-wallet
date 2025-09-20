<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class SuccessResponse extends JsonResponse
{
    public readonly bool $success;

    public function __construct(string $json)
    {
        $this->success = true;

        parent::__construct(data: $json, json: true);
    }
}
