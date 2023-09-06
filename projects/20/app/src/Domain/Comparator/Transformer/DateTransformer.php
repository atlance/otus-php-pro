<?php

declare(strict_types=1);

namespace App\Domain\Comparator\Transformer;

use App\Domain\Comparator\Contract\TransformerInterface;
use App\Exceptions\UnexpectedValueException;
use DateTime;

/**
 * @implements TransformerInterface<DateTime>
 */
final class DateTransformer implements TransformerInterface
{
    public function __construct(private readonly string $format)
    {
    }

    /** {@inheritdoc} */
    public function reverseTransform(mixed $value): string
    {
        if (\is_string($value)) {
            return $value;
        }

        if ($value instanceof \DateTime) {
            return $value->format($this->format);
        }
        //phpcs:disable
        throw new UnexpectedValueException(sprintf('expected string or DateTime type, given %s type', get_debug_type($value)));
        //phpcs:enable
    }

    /** {@inheritdoc} */
    public function transform(mixed $value): DateTime
    {
        if (\is_string($value) && ($date = \DateTime::createFromFormat($this->format, $value)) instanceof DateTime) {
            return $date;
        }

        if ($value instanceof \DateTime) {
            return $value;
        }

        throw new UnexpectedValueException(sprintf('expected string type, given %s type', get_debug_type($value)));
    }
}
