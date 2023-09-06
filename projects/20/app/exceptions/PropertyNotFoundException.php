<?php

declare(strict_types=1);

namespace App\Exceptions;

class PropertyNotFoundException extends \DomainException
{
    public function __construct(string $className, string $property)
    {
        parent::__construct("{$className}::{$property} not found");
    }
}
