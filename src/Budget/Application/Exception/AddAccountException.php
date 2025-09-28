<?php
declare(strict_types=1);


namespace App\Budget\Application\Exception;

use App\Budget\BaseBudgetApplicationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class AddAccountException extends BaseBudgetApplicationException
{
    public const MESSAGE = 'Add account error';

    public function __construct(string $message = self::MESSAGE, int $code = Response::HTTP_CONFLICT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}