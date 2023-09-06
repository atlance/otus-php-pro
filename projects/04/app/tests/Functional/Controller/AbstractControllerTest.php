<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AbstractControllerTest extends TestCase
{
    protected ?HttpClientInterface $client = null;

    protected function setUp(): void
    {
        $this->client = HttpClient::create(['base_uri' => 'http://nginx-upstream']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
    }
}
