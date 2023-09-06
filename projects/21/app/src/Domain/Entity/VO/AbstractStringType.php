<?php

declare(strict_types=1);

namespace App\Domain\Entity\VO;

abstract class AbstractStringType implements \Stringable
{
    protected string $value;

    final public function isEqual(?self $other = null): bool
    {
        if ($other instanceof self) {
            return $this->getValue() === $other->getValue();
        }

        return false;
    }

    final public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
