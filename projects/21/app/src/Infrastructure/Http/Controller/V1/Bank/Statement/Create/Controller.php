<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\V1\Bank\Statement\Create;

use App\Domain\Bus\Contract\Command\BusInterface;
use App\Domain\Command\UseCase\Bank\Statement\Create\Command;
use App\Infrastructure\Http\Attributes\Request;
use App\Infrastructure\Http\Attributes\Response;
use App\Infrastructure\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Request\Method\Post('/bank/statements', name: self::class)]
#[Request\Body(Command::class)]
#[Response\Created]
#[Response\BadRequest]
final class Controller extends AbstractController
{
    public function __invoke(#[MapRequestPayload] Command $command, BusInterface $bus): JsonResponse
    {
        $bus->dispatch($command);

        return $this->json(['id' => (string) $command->getId()]);
    }
}
