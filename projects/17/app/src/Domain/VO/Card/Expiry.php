<?php

declare(strict_types=1);

namespace App\Domain\VO\Card;

use App\Exceptions\Assert\Assert;
use App\Exceptions\UnexpectedValueException;
use DateTimeInterface;

/**
 * Месяц и год истечения срока действия карты.
 */
final class Expiry implements \Stringable
{
    public const FORMAT = 'm/y';
    /** @var string месяц(01-12)/год(2 символа, только числа) */
    public const PATTERN = '#^(0[1-9]|1[0-2])\/(\d{2})$#';

    /** @var non-empty-string */
    private readonly string $value;

    /** @param non-empty-string $value*/
    public function __construct(string $value)
    {
        Assert::mach(self::PATTERN, $value, sprintf('expected %s format', self::FORMAT));

        $this->value = $value;
    }

    /** @return non-empty-string */
    public function getValue(): string
    {
        return $this->value;
    }

    public function toDateTime(): DateTimeInterface
    {
        $datetime = \DateTime::createFromFormat('d/' . self::FORMAT, "01/{$this->value}");
        if (false === $datetime) {
            throw new UnexpectedValueException();
        }

        $datetime
            ->setTime(23, 59, 59, 999_999)
            ->modify('last day of');

        return $datetime;
    }

    public static function fromDateTime(DateTimeInterface $dateTime): self
    {
        return new self($dateTime->format(self::FORMAT));
    }

    /** @return non-empty-string */
    public function __toString(): string
    {
        return $this->value;
    }
}
