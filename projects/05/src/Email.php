<?php

declare(strict_types=1);

namespace Atlance\EmailValidator;

final class Email
{
    public function __construct(private readonly string $value)
    {
    }

    /** @psalm-suppress PossiblyFalseOperand */
    public function host(): string
    {
        return mb_substr($this->value, mb_strpos($this->value, '@') + 1);
    }

    public function isLocal(): bool
    {
        return 1 >= count(explode('.', $this->host()));
    }

    public function topLevelDomain(): string
    {
        $hostParts = explode('.', $this->host());

        return $hostParts[(count($hostParts) - 1)];
    }
}
