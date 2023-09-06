<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\ServiceProviderInterface;

final class Resolver implements Contract\FactoryResolverInterface
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_FORBIDDEN;

    /** @param ServiceProviderInterface<Contract\FactoryInterface> $handlers*/
    public function __construct(private readonly ServiceProviderInterface $handlers)
    {
    }

    public function resolve(int $statusCode): Contract\FactoryInterface
    {
        if ($this->handlers->has((string) $statusCode)) {
            return $this->handlers->get((string) $statusCode);
        }

        return $this->handlers->get((string) self::DEFAULT_STATUS_CODE);
    }
}
