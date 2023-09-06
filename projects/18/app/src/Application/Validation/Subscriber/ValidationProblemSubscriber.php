<?php

declare(strict_types=1);

namespace App\Application\Validation\Subscriber;

use App\Application\Validation\Exception\Contract\ValidationProblemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ValidationProblemSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof ValidationProblemInterface) {
            return;
        }

        $event->setResponse(new JsonResponse($exception->toArray(), Response::HTTP_BAD_REQUEST));
    }

    /** @codeCoverageIgnore */
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => [['onKernelException', 255]]];
    }
}
