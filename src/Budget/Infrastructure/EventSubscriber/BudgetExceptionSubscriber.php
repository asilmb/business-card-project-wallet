<?php

declare(strict_types=1);

namespace App\Budget\Infrastructure\EventSubscriber;

use App\Budget\BaseBudgetApplicationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

class BudgetExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $this->getOriginalException($event->getThrowable());

        if ($exception instanceof BaseBudgetApplicationException) {
            $responseData = [
                'message' => $exception->getMessage(),
            ];

            $response = new JsonResponse($responseData, $exception->getCode());

            $event->setResponse($response);
        }
    }

    private function getOriginalException(Throwable $e): Throwable
    {
        return $e->getPrevious() ? $this->getOriginalException($e->getPrevious()) : $e;
    }
}
