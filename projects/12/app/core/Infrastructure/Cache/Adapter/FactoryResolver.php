<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Adapter;

use App\Exceptions\InvalidArgumentException;
use Symfony\Contracts\Service\ServiceProviderInterface;

final class FactoryResolver
{
    /** @param ServiceProviderInterface<FactoryInterface> $adapters*/
    public function __construct(private readonly ServiceProviderInterface $adapters)
    {
    }

    public function resolve(string $adapter): FactoryInterface
    {
        if ($this->adapters->has($adapter)) {
            return $this->adapters->get($adapter);
        }

        throw new InvalidArgumentException(sprintf('Adapter: "%s" - is not supported.', $adapter));
    }
}
