<?php

namespace App\Shared\Infrastructure\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

class ValidationExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $this->getOriginalException($event->getThrowable());

        if ($exception instanceof ValidationFailedException) {
            $violations = [];
            foreach ($exception->getViolations() as $violation) {
                $violations[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            $responseData = [
                'error' => 'validation_failed',
                'violations' => $violations,
            ];

            $response = new JsonResponse($responseData, Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    private function getOriginalException(\Throwable $e): \Throwable
    {
        return $e->getPrevious() ? $this->getOriginalException($e->getPrevious()) : $e;
    }
}
