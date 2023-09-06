<?php

declare(strict_types=1);

namespace App\Exceptions;

class UnexpectedClassException extends \DomainException
{
    public function __construct(string $expectedClassName, string $unexpectedClassName)
    {
        parent::__construct("expected class {$expectedClassName}, {$unexpectedClassName} given");
    }
}
