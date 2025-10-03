<?php

declare(strict_types=1);

namespace Brick\Controller;

class LoginController
{
  /**
   * Zeigt die Login-Seite an oder leitet eingeloggte User zum Dashboard weiter
   */
  public function showLogin(): void
  {
    // Prüfen ob dies eine Vorschau-Anfrage ist
    $isPreview = isset($_GET['preview']) && $_GET['preview'] === 'true';
    
    // Prüfen ob Benutzer bereits eingeloggt ist
    if ($this->isLoggedIn() && !$isPreview) {
      // Bereits eingeloggt → zum Dashboard weiterleiten (außer bei Vorschau)
      header('Location: /' . ADMIN_DASHBOARD);
      exit;
    }

    // Login-Seite anzeigen (auch bei eingeloggten Usern wenn Vorschau-Modus)
    require_once VIEW_DIR . '/auth/login.php';
  }

  public function authenticate(): void
  {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
      echo "Email und Passwort sind erforderlich!";
      return;
    }

    // User aus Konfiguration laden
    $user = $this->findUserByEmail($email);

    if ($user === null) {
      echo "Benutzer nicht gefunden!";
      return;
    }

    // Credentials verifizieren
    $verificationResult = $this->verify($user, $password);
    
    if ($verificationResult !== true) {
      echo $verificationResult; // Fehlermeldung anzeigen
      return;
    }

    // Login erfolgreich - Session erstellen
    $this->createUserSession($user);
    
    // Nach erfolgreichem Login zur ursprünglich angeforderten Seite weiterleiten
    $this->redirectAfterLogin();
  }

  /**
   * Leitet nach erfolgreichem Login zur ursprünglich angeforderten Seite weiter
   */
  private function redirectAfterLogin(): void
  {
    // Prüfen ob eine Redirect-URL in der Session gespeichert ist
    $redirectUrl = $_SESSION['redirect_after_login'] ?? '/' . ADMIN_DASHBOARD;
    
    // Redirect-URL aus Session entfernen
    unset($_SESSION['redirect_after_login']);
    
    // Direkte Weiterleitung zum Dashboard
    header('Location: ' . $redirectUrl);
    exit;
  }

  /**
   * Verifiziert Passwort und Benutzerstatus
   * 
   * @param array $user Benutzerdaten
   * @param string $password Eingegebenes Passwort
   * @return true|string true bei Erfolg, Fehlermeldung bei Misserfolg
   */
  private function verify(array $user, string $password): true|string
  {
    // // DEBUG: Passwort-Verifikation Details anzeigen
    // echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px 0; border: 1px solid #ccc;'>";
    // echo "<h4>🔍 Debug: Passwort-Verifikation</h4>";
    // echo "<p><strong>Eingegebenes Passwort:</strong> " . htmlspecialchars($password) . "</p>";
    // echo "<p><strong>Gespeicherter Hash:</strong> " . htmlspecialchars($user['password']) . "</p>";
    // echo "<p><strong>Hash-Länge:</strong> " . strlen($user['password']) . " Zeichen</p>";
    // echo "<p><strong>Hash-Algorithmus-Info:</strong> " . password_get_info($user['password'])['algoName'] . "</p>";    
    // // Test mit bekannten Passwörtern
    // $testPasswords = ['Admin123!', 'Editor2025#', 'Viewer!2025'];
    // foreach ($testPasswords as $testPw) {
    //   $testResult = password_verify($testPw, $user['password']);
    //   echo "<p><strong>Test '{$testPw}':</strong> " . ($testResult ? '✅ MATCH' : '❌ NO MATCH') . "</p>";
    // }
    // echo "</div>";

    // Passwort prüfen
    $passwordValid = password_verify($password, $user['password']);
    
    if (!$passwordValid) {
      return "Ungültiges Passwort! (Debug: password_verify returned false)";
    }

    // Benutzer Status prüfen
    if ($user['status'] !== 'active') {
      return "Benutzer ist deaktiviert!";
    }

    // Zusätzliche Verifikationen können hier hinzugefügt werden:
    // - Account-Sperren nach mehreren Fehlversuchen
    // - Zwei-Faktor-Authentifizierung
    // - Zeitbasierte Zugriffsbeschränkungen
    // - etc.

    return true;
  }

  /**
   * Initialisiert die Session mit sicheren Parametern
   */
  private function initializeSecureSession(): void
  {
    // Nur ausführen wenn noch keine Session aktiv und noch keine Headers gesendet
    if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
      $this->secureSessionCookie();
    }
    
    // Session starten falls noch nicht aktiv
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  /**
   * Erstellt eine sichere User-Session mit wichtigen Informationen
   * 
   * @param array $user Vollständige Benutzerdaten
   * @return void
   */
  private function createUserSession(array $user): void
  {
    // Sichere Session initialisieren
    $this->initializeSecureSession();

    // Session regenerieren für Sicherheit (verhindert Session Fixation)
    session_regenerate_id(true);

    // Wichtige User-Informationen in Session speichern (ohne Passwort!)
    $_SESSION['user'] = [
      'id' => $user['id'],
      'name' => $user['name'],
      'email' => $user['email'],
      'role' => $user['role'],
      'status' => $user['status'],
      'created_at' => $user['created_at'],
      'login_time' => date('Y-m-d H:i:s'),
      'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
      'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];

    // Benutzer-Berechtigungen laden und in Session speichern
    // TODO: Rollen-System später aktivieren
    // $roles = $this->loadRoles();
    // $userRole = $user['role'] ?? '';
    
    // if (isset($roles[$userRole])) {
    //   $_SESSION['user']['permissions'] = $roles[$userRole]['permissions'] ?? [];
    // } else {
    //   $_SESSION['user']['permissions'] = [];
    // }

    // Temporär: Alle eingeloggten User haben alle Berechtigungen
    $_SESSION['user']['permissions'] = [
      'create_posts',
      'edit_posts', 
      'delete_posts',
      'manage_users',
      'access_admin',
      'view_analytics'
    ];

    // Session-Metadaten für Sicherheit
    $_SESSION['session_data'] = [
      'created_at' => time(),
      'last_activity' => time(),
      'csrf_token' => bin2hex(random_bytes(32)),
      'session_id' => session_id()
    ];

    // Session-Cookie Sicherheit ist bereits gesetzt (vor session_start)
  }

  /**
   * Setzt sichere Session-Cookie Parameter
   */
  private function secureSessionCookie(): void
  {
    // Nur setzen wenn Session noch nicht aktiv ist
    if (session_status() === PHP_SESSION_ACTIVE) {
      return;
    }

    $cookieParams = [
      'lifetime' => 0, // Session-Cookie (bis Browser geschlossen wird)
      'path' => '/',
      'domain' => '', // Aktueller Domain
      'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', // Nur über HTTPS
      'httponly' => true, // Nicht via JavaScript zugreifbar
      'samesite' => 'Strict' // CSRF-Schutz
    ];

    session_set_cookie_params($cookieParams);
  }

  /**
   * Prüft ob ein Benutzer eingeloggt ist
   */
  public function isLoggedIn(): bool
  {
    $this->initializeSecureSession();
    return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
  }

  /**
   * Gibt den aktuell eingeloggten Benutzer zurück
   */
  public function getCurrentUser(): ?array
  {
    if (!$this->isLoggedIn()) {
      return null;
    }

    // Letzte Aktivität aktualisieren
    $_SESSION['session_data']['last_activity'] = time();

    return $_SESSION['user'];
  }

  /**
   * Prüft ob der aktuelle Benutzer eine bestimmte Berechtigung hat
   */
  public function hasCurrentUserPermission(string $permission): bool
  {
    $user = $this->getCurrentUser();
    
    if ($user === null) {
      return false;
    }

    return in_array($permission, $user['permissions'] ?? [], true);
  }

  /**
   * Loggt den Benutzer aus und zerstört die Session
   */
  public function logout(): void
  {
    $this->initializeSecureSession();

    // Session-Daten löschen
    $_SESSION = [];

    // Session-Cookie löschen
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    // Session zerstören
    session_destroy();

    // Weiterleitung zur konfigurierten Logout-Seite
    header('Location: /' . ADMIN_AFTER_LOGOUT);
    exit;
  }

  /**
   * Debug-Methode: Zeigt aktuelle Session-Informationen
   */
  public function showSession(): void
  {
    $this->initializeSecureSession();

    echo "<h2>🔍 Session Debug</h2>";
    
    if ($this->isLoggedIn()) {
      $user = $this->getCurrentUser();
      
      echo "<div style='background: #e8f5e8; padding: 15px; border: 1px solid #4caf50; border-radius: 5px;'>";
      echo "<h3>✅ Benutzer eingeloggt</h3>";
      echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
      echo "<tr><th>Feld</th><th>Wert</th></tr>";
      
      foreach ($user as $key => $value) {
        if (is_array($value)) {
          $value = implode(', ', $value);
        }
        echo "<tr><td><strong>{$key}</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
      }
      
      echo "</table>";
      echo "</div>";
      
      // Session-Metadaten
      if (isset($_SESSION['session_data'])) {
        echo "<h4>Session-Metadaten:</h4>";
        echo "<pre>" . print_r($_SESSION['session_data'], true) . "</pre>";
      }
      
    } else {
      echo "<div style='background: #ffe8e8; padding: 15px; border: 1px solid #f44336; border-radius: 5px;'>";
      echo "<h3>❌ Nicht eingeloggt</h3>";
      echo "<p>Keine aktive Benutzer-Session gefunden.</p>";
      echo "</div>";
    }
    
    echo "<h4>Vollständige Session:</h4>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
  }

  /**
   * Sucht einen Benutzer anhand der E-Mail-Adresse
   */
  private function findUserByEmail(string $email): ?array
  {
    $users = $this->loadUsers();

    foreach ($users as $user) {
      if ($user['email'] === $email) {
        return $user;
      }
    }

    return null;
  }

  /**
   * Lädt alle Benutzer aus der Konfigurationsdatei
   */
  private function loadUsers(): array
  {
    $userConfig = CONFIG_DIR . '/user.php';

    if (!file_exists($userConfig)) {
      return [];
    }

    $config = require $userConfig;
    return $config['users'] ?? [];
  }

  /**
   * Lädt die Benutzerrollen aus der Konfiguration
   */
  private function loadRoles(): array
  {
    $userConfig = CONFIG_DIR . '/user.php';

    if (!file_exists($userConfig)) {
      return [];
    }

    $config = require $userConfig;
    return $config['roles'] ?? [];
  }

  /**
   * Prüft ob ein Benutzer eine bestimmte Berechtigung hat
   */
  private function hasPermission(array $user, string $permission): bool
  {
    $roles = $this->loadRoles();
    $userRole = $user['role'] ?? '';

    if (!isset($roles[$userRole])) {
      return false;
    }

    $permissions = $roles[$userRole]['permissions'] ?? [];
    return in_array($permission, $permissions, true);
  }

  /**
   * Hilfsmethode zum Generieren von Passwort-Hashes (für Development)
   * Verwendung: $hash = $this->generatePasswordHash('MeinPasswort');
   */
  private function generatePasswordHash(string $password): string
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  /**
   * Debug-Methode: Zeigt alle verfügbaren User mit ihren Daten (ohne Passwörter)
   */
  public function listUsers(): void
  {
    $users = $this->loadUsers();

    echo "<h2>Verfügbare Benutzer:</h2>";
    echo "<table border='1' style='border-collapse: collapse; margin: 20px 0;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Rolle</th><th>Status</th><th>Erstellt</th></tr>";

    foreach ($users as $user) {
      $status = $user['status'] === 'active' ? '✅ Aktiv' : '❌ Inaktiv';
      echo "<tr>";
      echo "<td>{$user['id']}</td>";
      echo "<td>" . htmlspecialchars($user['name']) . "</td>";
      echo "<td>" . htmlspecialchars($user['email']) . "</td>";
      echo "<td>" . htmlspecialchars($user['role']) . "</td>";
      echo "<td>{$status}</td>";
      echo "<td>{$user['created_at']}</td>";
      echo "</tr>";
    }

    echo "</table>";

    echo "<h3>Test-Credentials:</h3>";
    echo "<ul>";
    echo "<li><strong>Admin:</strong> jp@bitka.de / Admin123!</li>";
    echo "<li><strong>Editor:</strong> a.schmidt@example.com / Editor2025#</li>";
    echo "<li><strong>Viewer:</strong> m.mueller@example.com / Viewer!2025 (inaktiv)</li>";
    echo "</ul>";
  }

  /**
   * Debug-Methode: Generiert korrekte Passwort-Hashes für die Config
   */
  public function generateHashes(): void
  {
    $passwords = [
      'Admin123!' => 'Admin Passwort',
      'Editor2025#' => 'Editor Passwort', 
      'Viewer!2025' => 'Viewer Passwort'
    ];

    echo "<h2>🔐 Passwort-Hash Generator</h2>";
    echo "<p>Hier sind die korrekten Hashes für die app/config/user.php:</p>";
    
    echo "<table border='1' style='border-collapse: collapse; margin: 20px 0;'>";
    echo "<tr><th>Passwort</th><th>Beschreibung</th><th>Hash</th></tr>";
    
    foreach ($passwords as $password => $description) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      echo "<tr>";
      echo "<td><code>" . htmlspecialchars($password) . "</code></td>";
      echo "<td>{$description}</td>";
      echo "<td style='font-family: monospace; font-size: 11px;'>" . htmlspecialchars($hash) . "</td>";
      echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<h3>📋 Für user.php Config:</h3>";
    echo "<pre style='background: #f5f5f5; padding: 15px; border: 1px solid #ddd;'>";
    foreach ($passwords as $password => $description) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      echo "'password' => '" . $hash . "', // {$password}\n";
    }
    echo "</pre>";
  }
}
