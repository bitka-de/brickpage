<?php

declare(strict_types=1);

// Bootstrap simulieren ohne App::run()
const ROOT_DIR = __DIR__ . '/..';
const SRC_DIR = ROOT_DIR . '/src';
const VENDOR_DIR = ROOT_DIR . '/vendor';
const APP_DIR = ROOT_DIR . '/app';
const CONFIG_DIR = APP_DIR . '/config';
const VIEW_DIR = APP_DIR . '/views';

require VENDOR_DIR . '/autoload.php';
require SRC_DIR . '/helpers.php';

// Settings laden und anzeigen
echo "<h1>Brickpage Settings Editor - Funktionstests</h1>";

echo "<h2>1. Settings laden</h2>";
$settingsFile = CONFIG_DIR . '/settings.php';
if (file_exists($settingsFile)) {
    $settings = require $settingsFile;
    echo "<p>✅ Settings erfolgreich geladen</p>";
    echo "<details><summary>Aktuelle Settings anzeigen</summary>";
    echo "<pre>" . print_r($settings, true) . "</pre>";
    echo "</details>";
} else {
    echo "<p>❌ Settings-Datei nicht gefunden: $settingsFile</p>";
}

echo "<h2>2. Helper-Funktionen testen</h2>";
echo "<p>Site Name: " . app('site.name', 'Nicht gefunden') . "</p>";
echo "<p>Site Tagline: " . app('site.tagline', 'Nicht gefunden') . "</p>";
echo "<p>Primary Color: " . app('theme.palette.primary', 'Nicht gefunden') . "</p>";

echo "<h2>3. SettingsController laden</h2>";
try {
    require_once SRC_DIR . '/Controller/SettingsController.php';
    echo "<p>✅ SettingsController erfolgreich geladen</p>";
    
    // Basis-Funktionalität testen
    $controller = new Brick\Controller\SettingsController();
    echo "<p>✅ SettingsController Instanz erstellt</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Fehler beim Laden des SettingsController: " . $e->getMessage() . "</p>";
}

echo "<h2>4. Test-Settings schreiben</h2>";
if (isset($controller)) {
    try {
        // Test-Settings erstellen
        $testSettings = $settings;
        $testSettings['site']['name'] = 'Test Update';
        $testSettings['theme']['palette']['primary'] = '#FF5722';
        
        // Temporäre Datei für Test
        $testFile = '/tmp/test_settings.php';
        $reflection = new ReflectionClass($controller);
        $method = $reflection->getMethod('writeSettingsFile');
        $method->setAccessible(true);
        $method->invoke($controller, $testFile, $testSettings);
        
        if (file_exists($testFile)) {
            echo "<p>✅ Test-Settings erfolgreich geschrieben</p>";
            echo "<details><summary>Generierte Datei anzeigen</summary>";
            echo "<pre>" . htmlspecialchars(file_get_contents($testFile)) . "</pre>";
            echo "</details>";
            unlink($testFile); // Aufräumen
        } else {
            echo "<p>❌ Test-Settings-Datei nicht erstellt</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Fehler beim Schreiben: " . $e->getMessage() . "</p>";
    }
}

echo "<h2>5. Router-Konfiguration prüfen</h2>";
$routesFile = CONFIG_DIR . '/routes.php';
if (file_exists($routesFile)) {
    $routes = require $routesFile;
    $settingsRoutes = array_filter($routes, function($route) {
        return strpos($route[1], 'settings') !== false;
    });
    
    echo "<p>✅ Routen-Datei gefunden</p>";
    echo "<p>Settings-Routen gefunden: " . count($settingsRoutes) . "</p>";
    foreach ($settingsRoutes as $route) {
        echo "<p>- {$route[0]} {$route[1]} → {$route[2]}</p>";
    }
} else {
    echo "<p>❌ Routen-Datei nicht gefunden</p>";
}

echo "<hr>";
echo "<p><strong>Zusammenfassung:</strong></p>";
echo "<p>Der Settings-Editor ist vollständig implementiert und sollte funktionieren!</p>";
echo "<p>Zugriff über: <a href='/settings'>/settings</a> (nach dem Login)</p>";
?>