<?php

declare(strict_types=1);

namespace App\Bookstore\UseCase\Book\Search;

use App\Core\Command\AbstractCommand;
use App\Core\Encoders\Http\Query\HttpQueryEncoder;
use App\Core\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class Command extends AbstractCommand
{
    private const RANGE_EXPR = ['gt', 'gte', 'lt', 'lte'];

    public ?string $title = null; // Название.
    public ?string $category = null; // Жанр.

    #[Assert\All([new Assert\Regex(pattern: "/^(\d{3})\-(\d{3})$/", message: 'Неверный артикул {{ value }}.')])]
    public ?array $skus = null; // Артикул(ы).

    #[Assert\Positive(message: 'Неверная цена {{ value }}.')]
    public ?string $price = null; // Цена книги.

    #[AppAssert\ArrayKeys(keys: self::RANGE_EXPR)]
    #[Assert\All([new Assert\Positive(message: 'Неверная цена {{ value }}.')])]
    public ?array $rangePrice = null; //Диапазон цен на книги.

    public ?string $street = null; // Адрес магазина.

    #[Assert\PositiveOrZero(message: 'Неверное количество {{ value }}.')]
    public ?string $stock = null; //Количество товара(книг).

    #[AppAssert\ArrayKeys(keys: self::RANGE_EXPR)]
    #[Assert\All([new Assert\Positive(message: 'Неверное количество книг {{ value }}.')])]
    public ?array $rangeStock = null; //Диапазон количества товара(книг).

    public function setRangePrice(string $value): self
    {
        $this->rangePrice = HttpQueryEncoder::decode($value);

        return $this;
    }

    public function setRangeStock(string $value): self
    {
        $this->rangeStock = HttpQueryEncoder::decode($value);

        return $this;
    }
}
