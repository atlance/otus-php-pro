<?php

declare(strict_types=1);

namespace App\Domain\Entity\Bank;

enum Status: int
{
    case GENERATION = 0;
    case GENERATED = 1;
    public function alias(): string
    {
        return match ($this) {
            self::GENERATION => 'generation',
            self::GENERATED => 'generated',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::GENERATION => 'На стадии генерации.',
            self::GENERATED => 'Сгенерирован.',
        };
    }
}
