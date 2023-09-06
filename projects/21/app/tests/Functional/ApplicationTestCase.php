<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Factory\ContainerFactory;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApplicationTestCase extends BaseTestCase
{
    protected ?ContainerInterface $container = null;
    protected static ContainerInterface $staticContainer;

    protected function service(string $id)
    {
        return $this->container?->get($id);
    }

    protected function parameter(string $name): \UnitEnum | float | array | bool | int | string | null
    {
        return $this->container?->getParameter($name);
    }

    public static function setUpBeforeClass(): void
    {
        if (!isset(self::$staticContainer)) {
            self::$staticContainer = ContainerFactory::create(
                (string) getenv('APP_ENV'),
                (bool) getenv('APP_DEBUG')
            );
        }
    }

    protected function setUp(): void
    {
        $this->container = self::$staticContainer;
    }

    protected function tearDown(): void
    {
        $this->container = null;
    }
}
