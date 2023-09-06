<?php

declare(strict_types=1);

namespace App\Bookstore\Domain\Book\Entity;

final class Shop implements \Stringable
{
    public function __construct(public string $shop, public int $stock)
    {
    }

    public function __toString(): string
    {
        return sprintf('ул. %s (%s шт)', $this->shop, $this->stock);
    }
}
