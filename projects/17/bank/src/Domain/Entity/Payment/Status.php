<?php

declare(strict_types=1);

namespace App\Domain\Entity\Payment;

enum Status: int
{
    case PENDING = 0;
    case SUCCEEDED = 1;
    case CANCELED = 2;
    case FAILED = 3;
    public function alias(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::SUCCEEDED => 'succeeded',
            self::CANCELED => 'canceled',
            self::FAILED => 'failed',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::PENDING => 'Это платеж, который создан и ожидает действий от пользователя.',
            self::SUCCEEDED => 'Это платеж, который был оплачен.',
            self::CANCELED => 'Это платеж, который был отменен.',
            self::FAILED => 'Это платеж, в котором произошел сбой процесса оплаты.',
        };
    }
}
