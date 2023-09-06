<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal\Type;

use App\Domain\Entity\VO\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class EmailType extends StringType
{
    public const NAME = 'email';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): null | string
    {
        return $value instanceof Email ? $value->getValue() : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        return \is_string($value) ? new Email($value) : null;
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
