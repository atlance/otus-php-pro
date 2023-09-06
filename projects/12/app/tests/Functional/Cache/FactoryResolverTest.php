<?php

declare(strict_types=1);

namespace App\Tests\Functional\Cache;

use App\Core\Infrastructure\Cache\Adapter\FactoryResolver;
use App\Exceptions\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FactoryResolverTest extends KernelTestCase
{
    private ?FactoryResolver $factoryResolver = null;

    public function testNotSupportedAdapter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->getResolver()->resolve('Foo');
    }

    public function getResolver(): FactoryResolver
    {
        return $this->factoryResolver;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->factoryResolver = self::bootKernel()->getContainer()->get(FactoryResolver::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->factoryResolver = null;
    }
}
