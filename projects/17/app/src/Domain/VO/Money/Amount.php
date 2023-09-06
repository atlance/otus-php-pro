<?php

declare(strict_types=1);

namespace App\Domain\VO\Money;

use App\Exceptions\Assert\Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

class Amount implements \Stringable
{
    private string $value;
    private int $convertedValue;
    private string $currency = 'RUB';

    public function __construct(float | string | int $value)
    {
        Assert::numeric($value);

        $this->value = $value;
        $this->convertedValue = (int) round(100 * round((float) $this->value, 2));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    #[Ignore]
    public function getConvertedValue(): float
    {
        return round($this->convertedValue / 100, 2);
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    #[Ignore]
    public function isEquals(self $other): bool
    {
        return $this->getCurrency() === $other->getCurrency()
            && $this->getConvertedValue() === $other->getConvertedValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
