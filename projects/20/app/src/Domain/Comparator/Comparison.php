<?php

declare(strict_types=1);

namespace App\Domain\Comparator;

enum Comparison: string
{
    case EQ = '===';
    case NEQ = '!==';
    case GT = '>';
    case GTE = '>=';
    case LT = '<';
    case LTE = '<=';
    public function description(): string
    {
        return match ($this) {
            self::EQ => 'is equal to',
            self::NEQ => 'is not equal to',
            self::GT => 'is greater than',
            self::GTE => 'is greater than or equal to',
            self::LT => 'is less than',
            self::LTE => 'is less than or equal to'
        };
    }

    public function alias(): string
    {
        return match ($this) {
            self::EQ => 'eq',
            self::NEQ => 'neq',
            self::GT => 'gt',
            self::GTE => 'gte',
            self::LT => 'lt',
            self::LTE => 'lte'
        };
    }
}
