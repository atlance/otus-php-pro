<?php

declare(strict_types=1);

namespace App\EventStorage\Presentation\Controller\Event\All;

use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Controller\Attributes\Get;
use App\EventStorage\Application\UseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Get('/all', name: self::class)]
final class Controller extends AbstractController
{
    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function __invoke(Request $request, UseCase\Event\All\Handler $handler): JsonResponse
    {
        return $this->json($handler->handle());
    }
}
