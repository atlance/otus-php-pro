<?php

declare(strict_types=1);

namespace App\Exceptions;

final class UnexpectedClassException extends \DomainException
{
    public function __construct(string $expectedClassName)
    {
        parent::__construct("expected class/interface {$expectedClassName}");
    }
}
