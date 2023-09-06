<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo\Factory;

final class Connection
{
    private static ?\PDO $pdo = null;

    private function __construct()
    {
        self::$pdo = new \PDO(
            getenv('APP_DATABASE_DSN'),
            getenv('POSTGRES_USER'),
            getenv('POSTGRES_PASSWORD')
        );
        self::$pdo->beginTransaction();
    }

    public static function getInstance(): \PDO
    {
        if (null === self::$pdo) {
            new self();
        }

        return self::$pdo;
    }

    public static function close()
    {
        'test' === getenv('APP_ENV')
            ? self::$pdo?->rollBack()
            : self::$pdo?->commit()
        ;

        self::$pdo = null;
    }

    private function __clone()
    {
    }
}
