<?php
declare(strict_types=1);

namespace App\Access\Application\Exception;

use App\Access\BaseAccessApplicationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UserCredentialsIsNotValidException extends BaseAccessApplicationException
{

    public function __construct(string $message = '', int $code = Response::HTTP_CONFLICT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}