<?php
declare(strict_types=1);

namespace App\Access\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UserWithAlreadyExistsException extends BaseAccessApplicationException
{
    public const MESSAGE = 'User with this email already exists.';

    public function __construct(string $message = self::MESSAGE, int $code = Response::HTTP_CONFLICT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}