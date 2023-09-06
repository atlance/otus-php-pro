<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo\Factory;

final class IdentityMap
{
    private array $map;
    /** @var array<string, IdentityMap> */
    private static array $instances = [];

    private function __construct()
    {
        $this->map = [];
    }

    public function find(int | string $id)
    {
        if (!\array_key_exists($id, $this->map)) {
            return null;
        }

        return $this->map[$id];
    }

    public function delete(int | string $id): void
    {
        if (!\array_key_exists($id, $this->map)) {
            return;
        }

        unset($this->map[$id]);
    }

    public function set(int | string $id, $value): void
    {
        $this->map[$id] = $value;
    }

    public static function getInstance(string $key): self
    {
        if (!\array_key_exists($key, self::$instances)) {
            self::$instances[$key] = new self();
        }

        return self::$instances[$key];
    }

    public static function clear()
    {
        foreach (array_keys(self::$instances) as $key) {
            unset(self::$instances[$key]);
        }
    }

    private function __clone()
    {
    }
}
