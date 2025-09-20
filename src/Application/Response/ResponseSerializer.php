<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class ResponseSerializer
{
    public function __construct(
        public readonly SerializerInterface $serializer,
    ) {
    }

    public function successResponse(object $responseObject): SuccessResponse
    {
        return new SuccessResponse(
            $this->serializer->serialize(
                [
                    'success' => true,
                    'data'    => $responseObject,
                ],
                JsonEncoder::FORMAT,
            ),
        );
    }

    public function successEmptyResponse(): SuccessEmptyResponse
    {
        return new SuccessEmptyResponse();
    }

    public function errorResponse(string $error, ?string $message = null): ErrorResponse
    {
        return new ErrorResponse($error, $message);
    }

    public function userErrorResponse(string $message): ErrorResponse
    {
        return new ErrorResponse('', $message);
    }
}
