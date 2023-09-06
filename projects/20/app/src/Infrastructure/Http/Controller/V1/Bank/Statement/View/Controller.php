<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\V1\Bank\Statement\View;

use App\Domain\Bus\Contract\Query\BusInterface;
use App\Domain\Query\UseCase\Bank\Statement\View\Query;
use App\Domain\Query\UseCase\Bank\Statement\View\Statement;
use App\Infrastructure\Http\Attributes\Request;
use App\Infrastructure\Http\Attributes\Request\Requirement\Uuid;
use App\Infrastructure\Http\Attributes\Response;
use App\Infrastructure\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Uid\UuidV7;

#[Request\Method\Get('/bank/statements/{id}', name: self::class, requirements: ['id' => Uuid::PATTERN])]
#[Response\Ok(Statement::class)]
#[Response\NotFound]
final class Controller extends AbstractController
{
    public function __invoke(UuidV7 $id, BusInterface $bus): JsonResponse
    {
        $object = $bus->dispatch(Query::fromArray(['id' => $id]));

        return null !== $object ? $this->json($object) : $this->notFound();
    }
}
