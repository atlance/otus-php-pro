<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal\Type\Order;

use App\Domain\Entity\Order\VO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class NumberType extends StringType
{
    public const NAME = 'order_number';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): null | string
    {
        return $value instanceof VO\Number ? $value->getValue() : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?VO\Number
    {
        return \is_string($value) ? new VO\Number($value) : null;
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
