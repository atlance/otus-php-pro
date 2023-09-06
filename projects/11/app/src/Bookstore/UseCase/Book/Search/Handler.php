<?php

declare(strict_types=1);

namespace App\Bookstore\UseCase\Book\Search;

use App\Bookstore\Domain\Book\Entity\Book;
use App\Core\Infrastructure\ElasticSearch\Query;

final class Handler
{
    /** @param Query\Finder<Book> $finder */
    public function __construct(private readonly Query\Builder $builder, private readonly Query\Finder $finder)
    {
    }

    /** @return Book[] */
    public function handle(Command $command): array
    {
        $query = $this->builder
            // phpcs:disable
            ->applyIfNotNull($command->title, 'addMustMatchQuery', 'title', ['query' => $command->title, 'fuzziness' => 2])
            // phpcs:enable
            ->applyIfNotNull($command->category, 'addMustTerm', 'category.keyword', $command->category)
            ->applyIfNotNull($command->skus, 'addMustTerms', 'sku.keyword', $command->skus)
            ->applyIfNotNull($command->price, 'addMustTerm', 'price', $command->price)
            ->applyIfNotNull($command->rangePrice, 'addMustRange', 'price', $command->rangePrice)
            // phpcs:disable
            ->applyIfNotNull($command->street, 'addMustNestedTerm', 'stock', ['stock.shop.keyword' => $command->street])
            ->applyIfNotNull($command->stock, 'addMustNestedTerm', 'stock', ['stock.stock' => $command->stock])
            ->applyIfNotNull($command->rangeStock, 'addMustNestedRange', 'stock', ['name' => 'stock.stock', 'values' => $command->rangeStock])
            // phpcs:enable
            ->build()
        ;

        return $this->finder->find(Book::class, $query);
    }
}
