<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

class TestCase extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?RouterInterface $router = null;

    public function requester(): Requester
    {
        if (null === $this->client || null === $this->router) {
            throw new \UnexpectedValueException('KernelBrowser & RouterInterface');
        }

        return new Requester($this->client, $this->router);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->router = static::$kernel->getContainer()->get('router');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
        $this->router = null;
    }
}
