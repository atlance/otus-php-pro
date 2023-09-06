<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity\Contracts;

interface IdentityInterface
{
    public function getId(): int | string;
}
