<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class ErrorResponse extends JsonResponse
{
    public readonly bool $success;
    public readonly string $error;
    public readonly ?string $message;

    public function __construct(string $error, ?string $message = null)
    {
        $this->success = false;
        $this->error = $error;
        $this->message = $message;

        parent::__construct([
            'success' => $this->success,
            'error'   => $this->error,
            'message' => $this->message,
        ]);
    }

}
