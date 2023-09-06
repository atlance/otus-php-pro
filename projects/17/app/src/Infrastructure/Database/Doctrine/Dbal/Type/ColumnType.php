<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal\Type;

final class ColumnType
{
    // Default built-in types provided by Doctrine DBAL.
    final public const ARRAY = 'array';
    final public const ASCII_STRING = 'ascii_string';
    final public const BIGINT = 'bigint';
    final public const BINARY = 'binary';
    final public const BLOB = 'blob';
    final public const BOOLEAN = 'boolean';
    final public const DATE_MUTABLE = 'date';
    final public const DATE_IMMUTABLE = 'date_immutable';
    final public const DATEINTERVAL = 'dateinterval';
    final public const DATETIME_MUTABLE = 'datetime';
    final public const DATETIME_IMMUTABLE = 'datetime_immutable';
    final public const DATETIMETZ_MUTABLE = 'datetimetz';
    final public const DATETIMETZ_IMMUTABLE = 'datetimetz_immutable';
    final public const DECIMAL = 'decimal';
    final public const FLOAT = 'float';
    final public const GUID = 'guid';
    final public const INTEGER = 'integer';
    final public const JSON = 'json';
    final public const OBJECT = 'object';
    final public const SIMPLE_ARRAY = 'simple_array';
    final public const SMALLINT = 'smallint';
    final public const STRING = 'string';
    final public const TEXT = 'text';
    final public const TIME_MUTABLE = 'time';
    final public const TIME_IMMUTABLE = 'time_immutable';

    // symfony types.
    final public const UUID = 'uuid';

    // application types.
    final public const MONEY_AMOUNT = Money\AmountType::NAME;
    final public const ORDER_NUMBER = Order\NumberType::NAME;
}
