<?php

declare(strict_types=1);

namespace App\EventStorage\Domain\Entity\Event;

use App\Contracts\IdentityInterface;
use Symfony\Component\Uid\Uuid;

final class Condition implements IdentityInterface
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $eventId,
        private string $name,
        private int $value,
    ) {
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getEventId(): string
    {
        return $this->eventId->toRfc4122();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
