<?php

declare(strict_types=1);

namespace App\EventStorage\Presentation\Controller\Event\Find;

use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Controller\Attributes\Get;
use App\Core\Presentation\Controller\Attributes\Requirements\UuidPattern;
use App\EventStorage\Application\UseCase;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Get('/find/{id}', name: self::class, requirements: ['id' => UuidPattern::VALUE])]
final class Controller extends AbstractController
{
    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function __invoke(string $id, UseCase\Event\Find\Handler $handler): JsonResponse
    {
        return $this->json($handler->handle($id));
    }
}
