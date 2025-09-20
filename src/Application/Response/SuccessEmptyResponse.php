<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class SuccessEmptyResponse extends JsonResponse
{
    public readonly bool $success;

    public function __construct()
    {
        $this->success = true;

        parent::__construct([
            'success' => $this->success,
        ]);
    }
}
