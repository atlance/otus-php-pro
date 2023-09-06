<?php

declare(strict_types=1);

namespace App\Domain\Entity\Bank;

use Symfony\Component\Uid\UuidV7;

class Statement
{
    public function __construct(
        private readonly string $email,
        private readonly string $startDate,
        private readonly string $endDate,
        private readonly UuidV7 $id = new UuidV7(),
    ) {
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }
}
