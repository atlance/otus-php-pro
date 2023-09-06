<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal\Type\BankCard;

use App\Domain\Entity\Card\VO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ExpiryType extends Type
{
    public const NAME = 'bank_card_expiry';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof VO\Expiry ? $value->toDateTime()->format('Y-m-d') : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?VO\Expiry
    {
        return \is_string($value) ? VO\Expiry::fromDateTime(new \DateTime($value)) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTypeDeclarationSQL($column);
    }
}
