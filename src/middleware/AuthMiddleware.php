<?php

declare(strict_types=1);

namespace Brick\Middleware;

use Brick\Core\Middleware;
use Brick\Controller\LoginController;

class AuthMiddleware implements Middleware
{
    private LoginController $loginController;

    public function __construct()
    {
        $this->loginController = new LoginController();
    }

    public function handle(string $method, string $uri): ?string
    {
        // Prüfen ob der User eingeloggt ist
        if (!$this->loginController->isLoggedIn()) {
            // User ist nicht eingeloggt - weiterleiten zur Login-Seite
            $this->redirectToLogin($uri);
            return 'STOP'; // Flow stoppen
        }

        // User ist eingeloggt - Zugriff gewährt für alle auth-geschützten Routen
        // TODO: Später Rollen-/Permissions-System aktivieren
        
        // // User ist eingeloggt - prüfen ob er Berechtigung für diese Route hat
        // if (!$this->hasRoutePermission($uri)) {
        //     $this->showAccessDenied();
        //     return 'STOP'; // Flow stoppen
        // }

        // Alles ok - Flow kann weitergehen
        return null;
    }

    /**
     * Leitet zur Login-Seite weiter und speichert die ursprüngliche URL
     */
    private function redirectToLogin(string $originalUri): void
    {
        // Ursprüngliche URL in Session speichern für Redirect nach Login
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['redirect_after_login'] = $originalUri;

        // Weiterleitung zur Login-Seite
        header('Location: /login');
        exit;
    }

    /**
     * Prüft ob der eingeloggte User Berechtigung für die Route hat
     */
    private function hasRoutePermission(string $uri): bool
    {
        // Route-spezifische Berechtigungen definieren
        $routePermissions = [
            '/admin' => 'access_admin',
            '/' . ADMIN_DASHBOARD => 'access_admin',
            '/admin/users' => 'manage_users',
            '/admin/posts' => 'edit_posts',
            '/admin/analytics' => 'view_analytics',
            // Weitere geschützte Routen hier hinzufügen
        ];

        // Prüfen ob Route spezielle Berechtigung benötigt
        foreach ($routePermissions as $route => $permission) {
            if (strpos($uri, $route) === 0) {
                return $this->loginController->hasCurrentUserPermission($permission);
            }
        }

        // Keine spezielle Berechtigung erforderlich - alle eingeloggten User haben Zugriff
        return true;
    }

    /**
     * Zeigt "Zugriff verweigert" Seite
     */
    private function showAccessDenied(): void
    {
        http_response_code(403);
        
        echo '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zugriff verweigert</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 40px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
        }
        .error-code { 
            font-size: 72px; 
            font-weight: bold; 
            color: #e74c3c; 
            margin: 0;
        }
        .error-message { 
            font-size: 24px; 
            color: #2c3e50; 
            margin: 20px 0;
        }
        .description { 
            color: #7f8c8d; 
            margin: 20px 0;
            line-height: 1.6;
        }
        .user-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px 5px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn:hover { background: #2980b9; }
        .btn-secondary { background: #95a5a6; }
        .btn-secondary:hover { background: #7f8c8d; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="error-code">403</h1>
        <h2 class="error-message">🚫 Zugriff verweigert</h2>
        <p class="description">
            Sie haben nicht die erforderlichen Berechtigungen, um auf diese Seite zuzugreifen.
        </p>';

        // Benutzerinformationen anzeigen
        $currentUser = $this->loginController->getCurrentUser();
        if ($currentUser) {
            echo '<div class="user-info">
                <strong>Eingeloggt als:</strong> ' . htmlspecialchars($currentUser['name']) . '<br>
                <strong>Rolle:</strong> ' . htmlspecialchars($currentUser['role']) . '<br>
                <strong>Berechtigungen:</strong> ' . implode(', ', $currentUser['permissions'] ?? []) . '
            </div>';
        }

        echo '<p class="description">
            Kontaktieren Sie Ihren Administrator, wenn Sie glauben, dass Sie Zugriff haben sollten.
        </p>
        
        <a href="/" class="btn">🏠 Zur Startseite</a>
        <a href="/' . ADMIN_DASHBOARD . '" class="btn btn-secondary">📊 Dashboard</a>
        <a href="/logout" class="btn btn-secondary">🚪 Logout</a>
    </div>
</body>
</html>';
    }
}