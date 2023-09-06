<?php

declare(strict_types=1);

namespace App\EventStorage\Presentation\Controller\Event\Storage\Clear;

use App\Core\Presentation\Controller\AbstractController;
use App\EventStorage\Application\UseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/storage/clear', name: self::class, methods: ['DELETE'])]
final class Controller extends AbstractController
{
    public function __invoke(UseCase\Event\Storage\Clear\Handler $handler): JsonResponse
    {
        return $this->emptyJson(statusCode: $handler->handle() ? Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }
}
