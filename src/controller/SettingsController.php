<?php

declare(strict_types=1);

namespace Brick\Controller;

use Brick\Core\Config;

class SettingsController
{
    /**
     * Zeigt die Settings-Seite an
     */
    public function show(): void
    {
        $settingsFile = CONFIG_DIR . '/settings.php';
        $settings = file_exists($settingsFile) ? require $settingsFile : [];
        require_once VIEW_DIR . '/admin/settings.php';
    }

    /**
     * Aktualisiert die Settings
     */
    public function update(): void
    {
        $data = $_POST;
        
        // CSRF-Token validieren (falls implementiert)
        
        // Settings-Datei aktualisieren
        $this->saveSettings($data);
        
        // Redirect mit Erfolgsmeldung
        header('Location: /settings?success=1');
        exit;
    }

    /**
     * Speichert die Settings in die Datei
     */
    private function saveSettings(array $data): void
    {
        $settingsFile = CONFIG_DIR . '/settings.php';
        
        // Aktuelle Settings laden
        $settings = require $settingsFile;
        
        // Site-Settings aktualisieren
        if (isset($data['site'])) {
            foreach ($data['site'] as $key => $value) {
                if (array_key_exists($key, $settings['site'])) {
                    $settings['site'][$key] = $value;
                }
            }
        }
        
        // Theme-Settings aktualisieren
        if (isset($data['theme'])) {
            foreach ($data['theme'] as $key => $value) {
                if ($key === 'palette' && is_array($value)) {
                    foreach ($value as $colorKey => $colorValue) {
                        if (array_key_exists($colorKey, $settings['theme']['palette'])) {
                            $settings['theme']['palette'][$colorKey] = $colorValue;
                        }
                    }
                } elseif (array_key_exists($key, $settings['theme'])) {
                    $settings['theme'][$key] = $value;
                }
            }
        }
        
        // Navigation aktualisieren
        if (isset($data['navigation']) && is_array($data['navigation'])) {
            $navigation = [];
            foreach ($data['navigation'] as $index => $nav) {
                if (!empty($nav['label']) && !empty($nav['path'])) {
                    $navigation[] = [
                        'label' => $nav['label'],
                        'path' => $nav['path']
                    ];
                }
            }
            $settings['navigation'] = $navigation;
        }
        
        // Integrations aktualisieren
        if (isset($data['integrations'])) {
            foreach ($data['integrations'] as $key => $value) {
                if (array_key_exists($key, $settings['integrations'])) {
                    foreach ($value as $subKey => $subValue) {
                        if (array_key_exists($subKey, $settings['integrations'][$key])) {
                            $settings['integrations'][$key][$subKey] = $subValue;
                        }
                    }
                }
            }
        }
        
        // Settings-Array in PHP-Datei schreiben
        $this->writeSettingsFile($settingsFile, $settings);
    }
    
    /**
     * Schreibt das Settings-Array in eine PHP-Datei
     */
    private function writeSettingsFile(string $filePath, array $settings): void
    {
        $content = "<?php\n\nreturn " . $this->arrayToPhpCode($settings, 0) . ";\n";
        file_put_contents($filePath, $content);
    }
    
    /**
     * Konvertiert ein Array in lesbaren PHP-Code
     */
    private function arrayToPhpCode(array $array, int $indent = 0): string
    {
        $spaces = str_repeat('  ', $indent);
        $nextSpaces = str_repeat('  ', $indent + 1);
        
        $lines = ["[\n"];
        
        foreach ($array as $key => $value) {
            $keyStr = is_string($key) ? "'" . addslashes($key) . "'" : $key;
            
            if (is_array($value)) {
                $lines[] = $nextSpaces . $keyStr . ' => ' . $this->arrayToPhpCode($value, $indent + 1) . ",\n";
            } elseif (is_string($value)) {
                $lines[] = $nextSpaces . $keyStr . ' => \'' . addslashes($value) . "',\n";
            } elseif (is_bool($value)) {
                $lines[] = $nextSpaces . $keyStr . ' => ' . ($value ? 'true' : 'false') . ",\n";
            } elseif (is_null($value)) {
                $lines[] = $nextSpaces . $keyStr . ' => null' . ",\n";
            } else {
                $lines[] = $nextSpaces . $keyStr . ' => ' . $value . ",\n";
            }
        }
        
        $lines[] = $spaces . ']';
        
        return implode('', $lines);
    }
}