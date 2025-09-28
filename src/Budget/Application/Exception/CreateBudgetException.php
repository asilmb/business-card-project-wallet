<?php

declare(strict_types=1);


namespace App\Budget\Application\Exception;

use App\Budget\BaseBudgetApplicationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateBudgetException extends BaseBudgetApplicationException
{
    public const MESSAGE = 'Create budget error';

    public function __construct(string $message = self::MESSAGE, int $code = Response::HTTP_CONFLICT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
