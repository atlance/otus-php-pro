<?php

declare(strict_types=1);

namespace App\Exceptions;

class NotExistClassException extends \DomainException
{
    public function __construct(string $className)
    {
        parent::__construct("class {$className} - not found");
    }
}
