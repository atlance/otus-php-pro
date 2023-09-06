<?php

declare(strict_types=1);

namespace App\Bookstore\Domain\Book\Entity;

use App\Core\Domain\Contracts\EntityInterface;
use App\Core\Domain\Traits\ColumnNamesTrait;

final class Book implements EntityInterface
{
    use ColumnNamesTrait;

    public const NAME = 'otus-shop';

    private string $sku;
    private string $title;
    private string $category;
    private int $price;
    /** @var Shop[] */
    private array $stock = [];

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @param array{shop: string, stock: int}[] $rows
     */
    public function setStock(array $rows): self
    {
        foreach ($rows as $row) {
            $this->stock[] = new Shop($row['shop'], $row['stock']);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'title' => $this->title,
            'category' => $this->category,
            'price' => $this->price,
            'stock' => implode(', ', array_map(fn (Shop $shop) => (string) $shop, $this->stock)),
        ];
    }

    public static function tableName(): string
    {
        return self::NAME;
    }
}
