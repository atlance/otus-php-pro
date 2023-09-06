<?php

declare(strict_types=1);

namespace App\Tests\Functional\Cache;

use App\Core\Infrastructure\Cache\Hydrator\Contracts\ObjectHydratorInterface;
use App\Core\Infrastructure\Cache\Hydrator\Exceptions\ExtractException;
use App\Core\Infrastructure\Cache\Hydrator\Exceptions\HydrateException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class HidratorTest extends KernelTestCase
{
    private ?ObjectHydratorInterface $hydrator = null;

    public function testHydrateException(): void
    {
        $this->expectException(HydrateException::class);
        $this->hydrator()->hydrate(null, 'Foo');
    }

    public function testExtractException(): void
    {
        $this->expectException(ExtractException::class);
        $this->hydrator()->extract(new \SplFileInfo(__FILE__));
    }

    public function hydrator(): ObjectHydratorInterface
    {
        return $this->hydrator;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hydrator = self::bootKernel()->getContainer()->get(ObjectHydratorInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->hydrator = null;
    }
}
