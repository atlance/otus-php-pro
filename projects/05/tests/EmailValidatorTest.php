<?php

declare(strict_types=1);

namespace Atlance\EmailValidator\Tests;

use PHPUnit\Framework\TestCase;
use Atlance\EmailValidator\EmailValidator;

class EmailValidatorTest extends TestCase
{
    public function datasets(): array
    {
        return [
            ['foo@gmail.com', true, true],
            ['foo@foo.local', true, false],
            ['foo@foo.local', false, true],
            ['foo@docker.host.internal', true, false],
            ['foo@docker.host.internal', false, true],
            ['foo@localhost', true, false],
            ['foo@localhost.local', false, true],
            ['foo', false, false],
            ['foo', true, false],
            ['foo@', false, false],
            ['foo@', true, false],
            ['1', false, false],
        ];
    }

    /** @dataProvider datasets */
    public function test(string $value, bool $strict, bool $isValid): void
    {
        $this->assertEquals($isValid, EmailValidator::isValid($value, $strict));
    }
}
