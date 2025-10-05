<?php

declare(strict_types=1);

// Bootstrap laden
require_once __DIR__ . '/../src/bootstrap.php';

// Manuelle Session simulieren für Tests
session_start();
$_SESSION['user'] = [
    'id' => 1,
    'name' => 'John Doe',
    'email' => 'admin@admin.de',
    'role' => 'admin',
    'status' => 'active',
    'permissions' => ['view.admin.dashboard', 'manage.users', 'view.reports']
];

// SettingsController testen
use Brick\Controller\SettingsController;

echo "<h1>Settings Controller Test</h1>";

// Settings anzeigen
echo "<h2>Settings View Test:</h2>";
$controller = new SettingsController();

try {
    $controller->show();
} catch (Exception $e) {
    echo "<div style='color: red;'>Fehler: " . $e->getMessage() . "</div>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}