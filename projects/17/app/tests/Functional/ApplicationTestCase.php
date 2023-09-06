<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Factory\ContainerFactory;
use Faker\Factory as DataFactory;
use Faker\Generator as DataGenerator;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApplicationTestCase extends BaseTestCase
{
    protected ?ContainerInterface $container = null;
    protected ?DataGenerator $dataGenerator = null;
    protected static ContainerInterface $staticContainer;
    protected static DataGenerator $staticDataGenerator;

    protected function service(string $id)
    {
        return $this->container?->get($id);
    }

    protected function parameter(string $name): \UnitEnum | float | array | bool | int | string | null
    {
        return $this->container?->getParameter($name);
    }

    public static function dg(): DataGenerator
    {
        if (!isset(self::$staticDataGenerator)) {
            self::$staticDataGenerator = DataFactory::create();
        }

        return self::$staticDataGenerator;
    }

    public static function setUpBeforeClass(): void
    {
        if (!isset(self::$staticContainer)) {
            self::$staticContainer = ContainerFactory::create(
                (string) getenv('APP_ENV'),
                (bool) getenv('APP_DEBUG')
            );
        }

        if (!isset(self::$staticDataGenerator)) {
            self::$staticDataGenerator = DataFactory::create();
        }
    }

    protected function setUp(): void
    {
        $this->container = self::$staticContainer;
        $this->dataGenerator = self::$staticDataGenerator;
    }

    protected function tearDown(): void
    {
        $this->container = null;
        $this->dataGenerator = null;
    }
}
