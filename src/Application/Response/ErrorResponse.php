<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class ErrorResponse extends JsonResponse
{
    public function __construct(int $status, ?string $message = null)
    {
        parent::__construct(data: [ 'message' => $message], status: $status);
    }
}
