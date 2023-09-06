<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal\Type\BankCard;

use App\Domain\Entity\Card\VO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class CvvType extends StringType
{
    public const NAME = 'bank_card_cvv';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): null | string
    {
        return $value instanceof VO\Cvv ? (string) $value : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?VO\Cvv
    {
        return \is_string($value) ? new VO\Cvv($value) : null;
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
