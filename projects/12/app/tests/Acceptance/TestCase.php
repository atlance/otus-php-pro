<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use App\Core\Infrastructure\Cache\Hydrator\Contracts\ObjectHydratorInterface;
use App\Exceptions\UnexpectedClassException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

class TestCase extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?RouterInterface $router = null;
    private ?ObjectHydratorInterface $hydrator = null;

    public function requester(): Requester
    {
        if (null === $this->client || null === $this->router) {
            throw new UnexpectedClassException('KernelBrowser & RouterInterface');
        }

        return new Requester($this->client, $this->router);
    }

    public function hydrator(): ObjectHydratorInterface
    {
        return $this->hydrator;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->router = static::$kernel->getContainer()->get('router');
        $this->hydrator = self::$kernel->getContainer()->get(ObjectHydratorInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
        $this->router = null;
        $this->hydrator = null;
    }
}
