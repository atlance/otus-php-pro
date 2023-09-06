<?php

declare(strict_types=1);

namespace Atlance\EmailValidator;

final class EmailValidator
{
    /**
     * Reserved Top Level DNS Names (https://tools.ietf.org/html/rfc2606#section-2),
     * mDNS and private DNS Namespaces (https://tools.ietf.org/html/rfc6762#appendix-G)
     */
    public const RESERVED = [
        // Reserved Top Level DNS Names
        'test',
        'example',
        'invalid',
        'localhost',

        // mDNS
        'local',

        // Private DNS Namespaces
        'intranet',
        'internal',
        'private',
        'corp',
        'home',
        'lan',
    ];

    // phpcs:disable
    private const EMAIL_PATTERN = '/^[a-zA-Z0-9.!#$%&\'*+\\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/';
    // phpcs:enable

    /** @param bool $strict - Check DNS records corresponding to a given Internet host, and fake/internal host. */
    public static function isValid(string $value, bool $strict = true): bool
    {
        if (!preg_match(self::EMAIL_PATTERN, $value)) {
            return false;
        }

        if (false === $strict) {
            return true;
        }

        $email = new Email($value);

        if ($email->isLocal() || in_array($email->topLevelDomain(), self::RESERVED, true)) {
            return false;
        }


        return dns_check_record($email->host());
    }
}
