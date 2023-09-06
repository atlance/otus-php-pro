<?php

declare(strict_types=1);

namespace App\Domain\Comparator;

use App\Domain\Comparator\Contract\CompareInterface;
use App\Domain\Comparator\Contract\TransformerInterface;
use App\Domain\Comparator\Transformer\DateTransformer;
use DateTime;

/**
 * @implements CompareInterface<string|DateTime,string|DateTime>
 * @implements TransformerInterface<DateTime>
 */
final class DateComparator implements CompareInterface, TransformerInterface
{
    private DateTransformer $transformer;

    public function __construct(private readonly Comparison $comparison, string $format)
    {
        $this->transformer = new DateTransformer($format);
    }

    /** {@inheritdoc} */
    public function compare(mixed $a, mixed $b): bool
    {
        $dateA = $this->transform($a);
        $dateB = $this->transform($b);

        $dateA->setTime(0, 0);
        $dateB->setTime(0, 0);

        return match ($this->comparison) {
            Comparison::EQ => $dateA === $dateB,
            Comparison::NEQ => $dateA !== $dateB,
            Comparison::GT => $dateA > $dateB,
            Comparison::GTE => $dateA >= $dateB,
            Comparison::LT => $dateA < $dateB,
            Comparison::LTE => $dateA <= $dateB,
        };
    }

    public function comparison(): Comparison
    {
        return $this->comparison;
    }

    public function transform(mixed $value): DateTime
    {
        return $this->transformer->transform($value);
    }

    public function reverseTransform(mixed $value): string
    {
        return $this->transformer->reverseTransform($value);
    }
}
