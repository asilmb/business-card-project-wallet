<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class ResponseSerializer
{
    public function __construct(
        public readonly SerializerInterface $serializer,
    ) {
    }

    public function successResponse(object $responseObject, int $status = Response::HTTP_OK): SuccessResponse
    {
        return new SuccessResponse(
            $this->serializer->serialize(
                [
                    'data'    => $responseObject,
                ],
                JsonEncoder::FORMAT,
            ),
            $status
        );
    }

    public function successEmptyResponse(): SuccessEmptyResponse
    {
        return new SuccessEmptyResponse();
    }

    public function errorResponse(string $message, int $status = Response::HTTP_BAD_REQUEST): ErrorResponse
    {
        return new ErrorResponse($status, $message);
    }
}
