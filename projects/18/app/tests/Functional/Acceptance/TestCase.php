<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance;

use App\Exceptions\UnexpectedClassException;
use App\Tests\Functional\ApplicationTestCase;
use App\Tests\Infrastructure\Http\Requester;

class TestCase extends ApplicationTestCase
{
    private ?Requester $requester = null;

    final public function requester(): Requester
    {
        if (null === $this->requester) {
            throw new UnexpectedClassException(Requester::class, 'null');
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
