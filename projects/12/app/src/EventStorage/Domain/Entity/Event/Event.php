<?php

declare(strict_types=1);

namespace App\EventStorage\Domain\Entity\Event;

use App\Core\Domain\Entity\Contracts\IdentityInterface;
use Symfony\Component\Uid\Uuid;

final class Event implements IdentityInterface
{
    public const TABLE = 'events';

    public function __construct(private readonly Uuid $id, private array $conditions, private int $priority)
    {
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }
}
