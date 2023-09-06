<?php

declare(strict_types=1);

namespace App\EventStorage\Domain\Entity\Event;

use App\Contracts\IdentityInterface;
use App\EventStorage\Infrastructure\Database\Pdo\Event\Condition\DataMapper;
use Symfony\Component\Uid\Uuid;

final class Event implements IdentityInterface
{
    private array $conditions;

    public function __construct(
        private readonly Uuid $id,
        private int $priority,
        private string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $value): self
    {
        $this->priority = $value;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $value): self
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @psalm-suppress RedundantPropertyInitializationCheck
     * @psalm-suppress MixedReturnTypeCoercion
     *
     * @return array<array-key, Condition>
     */
    public function getConditions(): array
    {
        if (!isset($this->conditions)) {
            $this->conditions = (new DataMapper())->findByEventId($this->getId());
        }

        return $this->conditions;
    }

    /**
     * @param array<array-key, Condition> $value
     *
     * @return $this
     */
    public function setConditions(array $value): self
    {
        $this->conditions = $value;

        return $this;
    }
}
