<?php

declare(strict_types=1);

namespace App\Domain\Entity\VO;

use App\Exceptions\Assert\Assert;

final class Email extends AbstractStringType
{
    // phpcs:disable
    public const PATTERN = '/^[a-zA-Z0-9.!#$%&\'*+\\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/';
    // phpcs:enable

    public function __construct(string $value)
    {
        $value = trim(mb_strtolower($value));

        Assert::notEmptyString($value);
        Assert::mach(self::PATTERN, $value);

        $this->value = $value;
    }
}
