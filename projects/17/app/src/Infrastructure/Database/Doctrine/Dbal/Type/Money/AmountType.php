<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal\Type\Money;

use App\Domain\VO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class AmountType extends StringType
{
    public const NAME = 'money_amount';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): null | string
    {
        return $value instanceof VO\Money\Amount ? $value->getValue() : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?VO\Money\Amount
    {
        return \is_string($value) ? new VO\Money\Amount($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
