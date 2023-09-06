<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Payment\Pay;

use App\Application\UseCase;
use App\Infrastructure\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/payment/pay', name: self::class, methods: ['POST'], format: 'application/json')]
final class Controller extends AbstractController
{
    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function __invoke(Request $request, UseCase\Payment\Pay\Handler $handler): JsonResponse
    {
        $command = UseCase\Payment\Pay\Command::fromHashtable($this->content($request));
        $this->validate($command);

        return $this->json($handler->handle($command));
    }
}
