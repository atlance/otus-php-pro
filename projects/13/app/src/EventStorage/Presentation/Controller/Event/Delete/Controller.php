<?php

declare(strict_types=1);

namespace App\EventStorage\Presentation\Controller\Event\Delete;

use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Controller\Attributes\Delete;
use App\Core\Presentation\Controller\Attributes\Requirements\UuidPattern;
use App\EventStorage\Application\UseCase;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Delete('/delete/{id}', name: self::class, requirements: ['id' => UuidPattern::VALUE])]
final class Controller extends AbstractController
{
    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function __invoke(string $id, UseCase\Event\Delete\Handler $handler): JsonResponse
    {
        $handler->handle($id);

        return $this->emptyJson();
    }
}
