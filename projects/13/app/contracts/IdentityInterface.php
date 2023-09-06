<?php

declare(strict_types=1);

namespace App\Contracts;

interface IdentityInterface
{
    public function getId(): int | string;
}
