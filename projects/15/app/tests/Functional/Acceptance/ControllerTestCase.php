<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance;

use App\Tests\Functional\KernelTestCase;
use App\Tests\Utils\Requester\Requester;

class ControllerTestCase extends KernelTestCase
{
    private ?Requester $requester = null;

    final public function requester(): Requester
    {
        if (null === $this->requester) {
            throw new \UnexpectedValueException(sprintf('Expected %s', Requester::class));
        }

        return $this->requester;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requester = new Requester($this->service('test.client'), $this->service('router'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->requester = null;
    }
}
