<?php

declare(strict_types=1);

namespace Brick\Core;

class Config
{
    private static array $config = [];
    private static bool $loaded = false;

    /**
     * Lädt die Konfiguration aus der app.php
     */
    private static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        $configFile = CONFIG_DIR . '/app.php';
        if (file_exists($configFile)) {
            self::$config = require $configFile;
        }

        self::$loaded = true;
    }

    /**
     * Holt einen Konfigurationswert
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::load();

        $keys = explode('.', $key);
        $value = self::$config;

        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Setzt einen Konfigurationswert zur Laufzeit
     */
    public static function set(string $key, mixed $value): void
    {
        self::load();

        $keys = explode('.', $key);
        $config = &self::$config;

        foreach ($keys as $segment) {
            if (!isset($config[$segment]) || !is_array($config[$segment])) {
                $config[$segment] = [];
            }
            $config = &$config[$segment];
        }

        $config = $value;
    }

    /**
     * Prüft ob eine Konfiguration existiert
     */
    public static function has(string $key): bool
    {
        return self::get($key) !== null;
    }

    /**
     * Gibt alle Konfigurationswerte zurück
     */
    public static function all(): array
    {
        self::load();
        return self::$config;
    }
}