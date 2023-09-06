<?php

declare(strict_types=1);

namespace App\Core\Application\Validation\Subscriber;

use App\Core\Application\Validation\Exceptions\ValidationProblem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ValidationProblemSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof ValidationProblem) {
            return;
        }

        $event->setResponse(new JsonResponse($exception->toArray(), $exception->getCode()));
    }

    /** @codeCoverageIgnore */
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => [['onKernelException', 255]]];
    }
}
