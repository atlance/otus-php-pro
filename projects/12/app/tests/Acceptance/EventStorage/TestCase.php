<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage;

use App\EventStorage\Infrastructure\Cache\Repository\Event\EventRepository;

class TestCase extends \App\Tests\Acceptance\TestCase
{
    private ?EventRepository $repository = null;

    public function repository(): EventRepository
    {
        return $this->repository;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = static::$kernel->getContainer()->get(EventRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->repository = null;
    }
}
