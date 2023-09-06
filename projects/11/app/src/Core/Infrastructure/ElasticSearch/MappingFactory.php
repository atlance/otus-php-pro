<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\ElasticSearch;

use JoliCode\Elastically\Client as Connection;
use Symfony\Contracts\Service\ServiceProviderInterface;

final class MappingFactory
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ServiceProviderInterface $definitions
    ) {
    }

    public function create(): void
    {
        /* @var string $tableName */
        foreach (array_keys($this->definitions->getProvidedServices()) as $tableName) {
            if (!\is_string($tableName)) {
                continue;
            }

            if ($this->connection->getIndex($tableName)->exists()) {
                continue;
            }

            $builder = $this->connection->getIndexBuilder();
            $builder->markAsLive($builder->createIndex($tableName), $tableName);
        }
    }
}
