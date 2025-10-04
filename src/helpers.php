<?php

declare(strict_types=1);

/**
 * Global Configuration Access
 * 
 * Diese Datei stellt globale Helper-Funktionen für den Zugriff auf 
 * die Anwendungskonfiguration zur Verfügung.
 */

/**
 * Globale Config-Instance
 */
$GLOBALS['_brick_config'] = null;

/**
 * Initialisiert die globale Konfiguration
 */
function _init_config(): void
{
    if ($GLOBALS['_brick_config'] === null) {
        $GLOBALS['_brick_config'] = Brick\Core\Config::all();
    }
}

/**
 * Ruft einen Konfigurationswert ab
 * 
 * @param string $key Dot-notation Schlüssel (z.B. 'app.name', 'vite.dev_server')
 * @param mixed $default Fallback-Wert falls Schlüssel nicht existiert
 * @return mixed
 */
function _get(string $key, mixed $default = null): mixed
{
    _init_config();
    
    // Dot-notation auflösen
    $keys = explode('.', $key);
    $value = $GLOBALS['_brick_config'];

    foreach ($keys as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

/**
 * Prüft ob ein Konfigurationswert existiert
 */
function _has(string $key): bool
{
    return _get($key) !== null;
}

/**
 * App Settings Access
 * 
 * Greift auf die settings.php zu (im Gegensatz zu _get() das app.php lädt)
 */
$GLOBALS['_app_settings'] = null;

/**
 * Initialisiert die App-Settings
 */
function _init_app_settings(): void
{
    if ($GLOBALS['_app_settings'] === null) {
        $settingsFile = CONFIG_DIR . '/settings.php';
        if (file_exists($settingsFile)) {
            $GLOBALS['_app_settings'] = require $settingsFile;
        } else {
            $GLOBALS['_app_settings'] = [];
        }
    }
}

/**
 * Ruft einen App-Settings Wert ab
 * 
 * @param string $key Dot-notation Schlüssel (z.B. 'site.name', 'theme.palette.primary')
 * @param mixed $default Fallback-Wert falls Schlüssel nicht existiert
 * @return mixed
 * 
 * Beispiele:
 * app('site.name') => 'Mein Startup'
 * app('theme.palette.primary') => '#1E88E5'
 * app('navigation.0.label') => 'Home'
 */
function app(string $key, mixed $default = null): mixed
{
    _init_app_settings();
    
    // Dot-notation auflösen
    $keys = explode('.', $key);
    $value = $GLOBALS['_app_settings'];

    foreach ($keys as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

/**
 * Prüft ob ein App-Settings Wert existiert
 */
function app_has(string $key): bool
{
    return app($key) !== null;
}

/**
 * Gibt alle App-Settings zurück
 */
function app_all(): array
{
    _init_app_settings();
    return $GLOBALS['_app_settings'];
}

/**
 * Legacy-Support: Kurze Aliase für häufig verwendete Werte
 */
function app_name(): string
{
    return _get('app_name', 'Brick Framework');
}

function app_version(): string
{
    return _get('app_version', '1.0.0');
}

function app_url(): string
{
    return _get('url', 'http://localhost');
}

function is_dev(): bool
{
    return _get('dev_mode', false);
}

function is_debug(): bool
{
    return _get('debug', false);
}