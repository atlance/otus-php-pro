<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Response\Contract;

interface FactoryResolverInterface
{
    public function resolve(int $statusCode): FactoryInterface;
}
