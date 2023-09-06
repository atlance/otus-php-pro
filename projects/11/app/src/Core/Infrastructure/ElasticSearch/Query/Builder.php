<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\ElasticSearch\Query;

use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchQuery;
use Elastica\Query\Nested;
use Elastica\Query\Range;
use Elastica\Query\Term;
use Elastica\Query\Terms;
use Elastica\QueryBuilder\DSL\Query;

final class Builder
{
    private BoolQuery $query;
    /** @var Nested[] */
    private array $nestedQueries = [];

    public function __construct()
    {
        $this->query = (new Query())->bool();
    }

    public function applyIfNotNull(mixed $value, string $method, string $field, mixed $query): self
    {
        if (null !== $value && \is_callable([$this, $method])) {
            $this->$method($field, $query); /* @phpstan-ignore-line */
        }

        return $this;
    }

    public function addMustMatchQuery(string $field, array $values): self
    {
        $this->query->addMust(new MatchQuery($field, $values));

        return $this;
    }

    /**
     * @param list<scalar> $values
     *
     * @return $this
     */
    public function addMustTerms(string $field, array $values): self
    {
        $this->query->addMust(new Terms($field, $values));

        return $this;
    }

    public function addMustRange(string $field, array $values): self
    {
        $this->query->addMust(new Range($field, $values));

        return $this;
    }

    public function addMustTerm(string $field, string | int $value): self
    {
        $this->query->addMust(new Term([$field => $value]));

        return $this;
    }

    public function addMustNestedTerm(string $path, array $values): self
    {
        return $this->addMustNestedQuery($path, new Term($values));
    }

    /**
     * @param array{name:string,values:array} $values
     *
     * @return $this
     */
    public function addMustNestedRange(string $path, array $values): self
    {
        return $this->addMustNestedQuery($path, new Range($values['name'], $values['values']));
    }

    public function build(): BoolQuery
    {
        foreach ($this->nestedQueries as $query) {
            $this->query->addMust($query);
        }

        return $this->query;
    }

    private function addMustNestedQuery(string $path, AbstractQuery $query): self
    {
        $nested = \array_key_exists($path, $this->nestedQueries)
            ? $this->nestedQueries[$path]
            : (new Nested())->setPath($path);

        /** @var BoolQuery $nestedQuery */
        $nestedQuery = $nested->hasParam('query')
            ? $nested->getParam('query')
            : (new Query())->bool();

        $nested->setQuery($nestedQuery->addMust($query));

        $this->nestedQueries[$path] = $nested;

        return $this;
    }
}
