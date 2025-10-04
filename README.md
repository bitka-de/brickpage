````markdown
<img src="./public/img/logo.png" alt="Brickpage — Logo" style="width:360px;max-width:100%;height:auto;display:block;margin:0;">

## Task #6: App Settings Framework & Configuration Management - 4. Oktober 2025

Implementierung eines umfassenden Konfigurationssystems mit der `app()` Funktion und Timezone-Management:

### App Settings Framework:
- **`app()` Helper Function**: Zentrale Funktion für Zugriff auf `app/config/settings.php` mit Dot-Notation
- **Settings Configuration**: Strukturierte Website-Konfiguration getrennt von System-Konfiguration
- **Timezone Integration**: Automatisches Setzen der PHP-Timezone aus den App-Settings
- **Fallback System**: Robuste Fallback-Werte für fehlende Konfigurationsschlüssel
- **Performance Optimierung**: Lazy Loading und Caching der Settings für bessere Performance

### App() Function Features:
```php
// Dot-Notation Zugriff auf verschachtelte Arrays
app('site.name')                    // => 'Mein Startup'
app('site.timezone')               // => 'Europe/Berlin'
app('theme.palette.primary')       // => '#1E88E5'
app('navigation.0.label')          // => 'Home'
app('pages.0.components.0.data.title') // => 'Schnell starten — sofort live'

// Fallback-Werte für nicht existierende Schlüssel
app('does.not.exist', 'Default')  // => 'Default'

// Helper-Funktionen für häufige Abfragen
app_has('site.name')               // => true/false
app_all()                          // => komplettes Settings-Array
```

### Settings Configuration Structure:
```php
// app/config/settings.php - Website-spezifische Konfiguration
return [
  'site' => [
    'name'     => 'Mein Startup',
    'tagline'  => 'Code live, Build fast',
    'language' => 'de',
    'timezone' => 'Europe/Berlin',
    'domain'   => 'www.meinstartup.de',
  ],
  'theme' => [
    'template' => 'business',
    'palette'  => [
      'primary'   => '#1E88E5',
      'secondary' => '#F5A623',
    ],
    'font'   => 'Inter',
    'layout' => 'standard',
  ],
  'navigation' => [
    ['label' => 'Home',      'path' => '/'],
    ['label' => 'Über uns',  'path' => '/about'],
    // ...weitere Navigation
  ],
  'integrations' => [
    'analytics' => ['provider' => 'ga', 'tracking_id' => 'UA-XXXXX-Y'],
    'mail'      => ['provider' => 'mailchimp', 'api_key' => 'xxx'],
  ],
  'publish' => [
    'auto_ssl' => true,
    'staging'  => true,
  ],
];
```

### Timezone Management:
```php
// Automatisches Timezone-Setup in bootstrap.php
$timezone = app('site.timezone', 'UTC');
date_default_timezone_set($timezone);

// Alle PHP-Datumsfunktionen verwenden jetzt die konfigurierte Timezone
echo date('Y-m-d H:i:s T'); // => '2025-10-04 13:40:47 CEST'
```

### Configuration Separation:
- **`app/config/app.php`**: System- und Framework-Konfiguration (Development-Mode, Assets, etc.)
- **`app/config/settings.php`**: Website- und Content-Konfiguration (Site-Name, Theme, Navigation)
- **Separate Helper Functions**: 
  - `_get()` für System-Config (app.php)
  - `app()` für Website-Settings (settings.php)

### Helper Functions Implementation:
```php
// In src/helpers.php erweitert
$GLOBALS['_app_settings'] = null;

function _init_app_settings(): void {
    if ($GLOBALS['_app_settings'] === null) {
        $settingsFile = CONFIG_DIR . '/settings.php';
        $GLOBALS['_app_settings'] = file_exists($settingsFile) 
            ? require $settingsFile 
            : [];
    }
}

function app(string $key, mixed $default = null): mixed {
    _init_app_settings();
    
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
```

### Bootstrap Integration:
```php
// Timezone aus App-Settings in src/bootstrap.php
require SRC_DIR . '/helpers.php';

// Timezone aus App-Settings setzen
$timezone = app('site.timezone', 'UTC');
date_default_timezone_set($timezone);

// Rest der Bootstrap-Logik...
```

### Usage Examples:
```php
// In Views - Website-Informationen
<title><?= app('site.name') ?> - <?= app('site.tagline') ?></title>
<html lang="<?= app('site.language') ?>">

// Theme-Variablen für CSS
<style>
:root {
  --primary-color: <?= app('theme.palette.primary') ?>;
  --secondary-color: <?= app('theme.palette.secondary') ?>;
}
</style>

// Navigation generieren
<?php foreach (app('navigation', []) as $item): ?>
  <a href="<?= $item['path'] ?>"><?= $item['label'] ?></a>
<?php endforeach; ?>

// Analytics Integration
<?php if (app('integrations.analytics.tracking_id')): ?>
  <script>
    gtag('config', '<?= app("integrations.analytics.tracking_id") ?>');
  </script>
<?php endif; ?>
```

### Configuration Management Benefits:
- **Trennung von Belangen**: System-Config vs. Website-Content getrennt
- **Einfache Template-Syntax**: Kurze `app()` Aufrufe statt verschachtelter Arrays
- **Typsicherheit**: Vollständige PHP-Konfiguration mit IDE-Unterstützung
- **Performance**: Lazy Loading und Caching für optimale Geschwindigkeit
- **Flexibilität**: Dot-Notation erlaubt beliebig tiefe Verschachtelung
- **Robustheit**: Fallback-System verhindert fatale Fehler bei fehlenden Keys

### File Changes in Task #6:
```
Modified Files:
├── src/helpers.php              - app() Function und App-Settings-System
├── src/bootstrap.php            - Timezone-Setup aus App-Settings
├── app/config/settings.php      - Website-Konfigurationsstruktur
├── app/views/home.php           - app() Function Integration
├── app/views/admin/dashboard.php - Settings-Zugriff über app()
└── tailwind.config.js           - Konfiguration Anpassungen

Development Tools:
├── test_app_function.php        - Temporäre Test-Datei (entfernt)
├── debug_settings.php           - Debug-Hilfsdatei (entfernt)
└── debug_detailed.php           - Detaillierte Config-Tests (entfernt)
```

### Future Settings Management:
- Admin-Interface für Settings-Bearbeitung geplant
- Visual Settings-Editor mit Live-Preview
- Import/Export von Konfigurationen
- Environment-spezifische Settings-Overrides
- Validation und Schema-Definition für Settings

## Task #5: View Management System & Code Editor mit Live-Vorschau - 3. Oktober 2025

Implementierung eines umfassenden View-Management-Systems mit integriertem Code-Editor für Live-Entwicklung:

### View Management Features:
- **View Manager Controller**: RESTful API für View-Verwaltung mit CRUD-Operationen
- **Template Generator**: Automatische View-Erstellung mit vorgefertigten Templates (Basic, Form, Table, Empty)
- **File System Integration**: Rekursives Scannen und Mapping von Views zu Routen
- **Protected Views**: Schutz kritischer System-Views vor versehentlichem Löschen
- **Route Detection**: Automatische Erkennung welche Routen auf Views verweisen
- **Controller Analysis**: Statische Code-Analyse um zu erkennen welche Controller Views verwenden

### Integrated Code Editor:
- **CodeMirror Integration**: Vollwertiger Code-Editor mit PHP/HTML/CSS/JS Syntax-Highlighting
- **Live Preview**: Echtzeit-Vorschau mit automatischer Aktualisierung (1s Debounce)
- **Split-View Interface**: Resizable Split-Panel zwischen Editor und Vorschau
- **Backup System**: Automatische Backups bei jedem Speichern mit Cleanup (max. 5 Backups)
- **Responsive Preview**: Device-spezifische Vorschau (Desktop/Tablet/Mobile) mit echten Viewport-Größen
- **Keyboard Shortcuts**: Strg+S (Speichern), Strg+P (Preview toggle), Strg+1/2/3 (Viewports)

### Route Parameter Support:
- **Dynamic Routing**: Unterstützung für URL-Parameter mit `{parameter}` Syntax
- **Parameter Injection**: Automatische Parameter-Übergabe an Controller-Methoden
- **Route Matching**: Erweiterte Route-Matching-Engine mit Parameter-Extraktion
- **Flexible URLs**: Unterstützung für `/editor/view/{viewName}` und ähnliche Muster

### Admin Dashboard Erweiterungen:
- **Views Section**: Vollständige View-Verwaltung mit Such- und Filterfunktionen
- **Route Management**: Erweiterte Routen-Tabelle mit Such-, Bearbeitungs- und Testfunktionen
- **Quick Actions**: Direkter Zugang zu Editor, View-Erstellung und Route-Testing
- **Real-time Updates**: Live-Aktualisierung nach View-Erstellungen und -Löschungen

### Template System:
```php
// Verfügbare View-Templates
'basic'  => HTML-Seite mit Navigation und Content-Bereich
'form'   => Formular-Template mit Validierung und Styling
'table'  => Daten-Tabelle mit Sorting und Actions
'empty'  => Minimales HTML-Grundgerüst
```

### Code Editor Features:
```javascript
// CodeMirror Konfiguration
mode: "application/x-httpd-php",
theme: "monokai",
lineNumbers: true,
autoCloseBrackets: true,
matchBrackets: true,
foldGutter: true,
lineWrapping: true
```

### API Endpoints:
```php
// View Management API
['POST', '/api/views/create', 'ViewManagerController.createView', ['auth']],
['GET',  '/api/views/list',   'ViewManagerController.listViews', ['auth']],
['DELETE', '/api/views/delete', 'ViewManagerController.deleteView', ['auth']],

// Code Editor Routes
['GET',  '/editor/view/{viewName}',    'EditorController.view', ['auth']],
['POST', '/editor/save/{viewName}',    'EditorController.save', ['auth']],
['POST', '/editor/preview/{viewName}', 'EditorController.preview', ['auth']],
```

### Editor Security Features:
- **Input Validation**: Strenge Validierung von View-Namen und Pfaden
- **Path Traversal Protection**: Schutz vor Directory-Traversal-Attacken
- **Authentication Required**: Alle Editor-Funktionen erfordern Authentication
- **Backup & Recovery**: Automatische Backups vor jeder Änderung
- **Error Handling**: Robuste Fehlerbehandlung mit benutzerfreundlichen Meldungen

### Live Preview System:
```php
// Preview-Generierung mit Temporary Files
$tempFile = tempnam(sys_get_temp_dir(), 'preview_' . $viewName);
file_put_contents($tempPhpFile, $content);
include $tempPhpFile; // Sichere Ausführung in isolierter Umgebung
```

### UI/UX Verbesserungen:
- **Responsive Split-Panels**: Intelligente Anpassung an verschiedene Bildschirmgrößen
- **Toast Notifications**: Benutzerfreundliche Erfolgs- und Fehlermeldungen
- **Loading States**: Visuelle Rückmeldung bei längeren Operationen
- **Unsaved Changes Warning**: Warnung vor Datenverlust bei Navigation
- **Real-time File Size**: Live-Anzeige der Dateigröße und Änderungsanzahl

### Development Workflow:
1. **View Creation**: Neue Views über Dashboard mit Template-Auswahl erstellen
2. **Instant Editing**: Direkter Editor-Zugang mit einem Klick
3. **Live Development**: Änderungen in Echtzeit in der Vorschau sehen
4. **Multi-Device Testing**: Verschiedene Viewport-Größen sofort testen
5. **Safe Deployment**: Backup-System schützt vor Datenverlust

### File Organization:
```
src/controller/
├── ViewManagerController.php  - View CRUD Operations
├── EditorController.php       - Code Editor Backend
└── LoginController.php        - Enhanced with Preview Support

src/core/
├── Editor.php                 - Editor UI Generation
└── Router.php                 - Enhanced with Parameter Support

app/backup/views/              - Automatic View Backups
```

### Deutsche Lokalisierung:
- **Vollständig deutsche UI**: Alle Editor- und Management-Interfaces
- **Benutzerfreundliche Fehlermeldungen**: Klare deutsche Error-Messages
- **Intuitive Navigation**: Deutsche Labels und Tooltips
- **Help & Documentation**: Deutsche Hilfetexte und Keyboard-Shortcuts

## Task #4: Vollständiges User Authentication System mit deutscher UI - 3. Oktober 2025

Implementierung eines professionellen Benutzer-Authentifizierungssystems mit sicherer Session-Verwaltung und moderner deutscher Benutzeroberfläche:

### Authentifizierungs-Features:
- **Complete Login System**: Sichere E-Mail/Passwort-Authentifizierung mit bcrypt
- **Session Management**: Secure PHP Sessions mit Regeneration und CSRF-Schutz
- **User Roles & Permissions**: Rollen-basiertes Berechtigungssystem (Admin, Editor, Viewer)
- **Auto-Redirect Logic**: Eingeloggte User werden automatisch zum Dashboard weitergeleitet
- **Logout Functionality**: Sichere Session-Zerstörung mit konfigurierbaren Redirects
- **Debug & Development**: Umfangreiche Debug-Tools für User-Management

### Sicherheits-Implementation:
```php
// Sichere Session-Initialisierung
private function secureSessionCookie(): void
{
    $cookieParams = [
        'lifetime' => 0,          // Session-Cookie
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']), // Nur über HTTPS
        'httponly' => true,       // Nicht via JavaScript zugreifbar
        'samesite' => 'Strict'    // CSRF-Schutz
    ];
    session_set_cookie_params($cookieParams);
}

// Passwort-Verifikation mit bcrypt
$passwordValid = password_verify($password, $user['password']);

// Session-Regeneration gegen Session Fixation
session_regenerate_id(true);
```

### User Management System:
```php
// Benutzer-Konfiguration in app/config/user.php
'users' => [
    [
        'id' => 1,
        'name' => 'JP Behrens',
        'email' => 'jp@bitka.de',
        'password' => '$2y$10$...',  // bcrypt Hash
        'role' => 'admin',
        'status' => 'active',
        'created_at' => '2025-10-01 10:00:00'
    ]
]

// Session-Daten (ohne Passwort!)
$_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'],
    'permissions' => ['create_posts', 'edit_posts', 'manage_users'],
    'login_time' => date('Y-m-d H:i:s'),
    'ip_address' => $_SERVER['REMOTE_ADDR']
];
```

### Authentication Controller Methods:
- **`showLogin()`**: Intelligente Login-Seiten-Anzeige mit Auto-Redirect
- **`authenticate()`**: E-Mail/Passwort-Verifikation mit Session-Erstellung
- **`logout()`**: Sichere Session-Zerstörung mit Cookie-Cleanup
- **`isLoggedIn()`**: Session-Status-Prüfung für Authorization
- **`getCurrentUser()`**: Aktueller User mit Permissions
- **`hasCurrentUserPermission()`**: Berechtigungs-Prüfung

### Smart Login Flow:
```php
public function showLogin(): void
{
    // Auto-Redirect für eingeloggte User
    if ($this->isLoggedIn()) {
        header('Location: /' . ADMIN_DASHBOARD);
        exit;
    }
    
    // Login-Seite für nicht authentifizierte User
    require_once VIEW_DIR . '/auth/login.php';
}
```

### Deutsche Authentication UI:
- **Professionelles Login-Interface**: Vertrauenserweckende deutsche Benutzeroberfläche
- **Vollständige Lokalisierung**: Alle Texte, Labels und Nachrichten auf Deutsch
- **Benutzerfreundliche Formulare**: Intuitive E-Mail/Passwort-Eingabe
- **Social Login Vorbereitung**: Google/Facebook Authentication UI-Components
- **Responsive Design**: Mobile-optimierte Authentication-Experience

### Tailwind Authentication Components:
```css
/* Spezialisierte Authentication Components in login.css */
@layer components {
  .login-container        // Vollbild-Container mit Gradient-Background
  .login-card            // Glassmorphism-Karte für Formulare
  .login-form            // Formular-Wrapper mit optimiertem Spacing
  .login-input           // Styled Inputs mit Focus-States und Icons
  .login-submit-button   // Primary Action Button mit Hover-Animationen
  .login-social-button   // Social Login Buttons (Google/Facebook)
  .login-debug           // Development Debug-Informationen
}
```

### Modular CSS-Architektur:
```
app/assets/css/
├── app.css          - Haupt-CSS mit Imports + Framework-Components
├── login.css        - Authentication-spezifische Components
└── [future]         - dashboard.css, forms.css, admin.css
```

### Authentication UI Design:
- **Professional Branding**: Blue-600/700 Corporate Identity mit Gradienten
- **Glassmorphism Effects**: Semi-transparente Karten mit Backdrop-Blur
- **Micro-Interactions**: Hover-Animationen und Focus-States
- **Icon Integration**: Heroicons v2 für visuelle Benutzerführung
- **Typography Hierarchy**: Inter-Font mit optimierten Größen
- **Accessibility**: ARIA-Labels, Keyboard-Navigation, Focus-Management

### Deutsche UI-Texte:
```html
<!-- Vollständig lokalisierte Authentication-Texte -->
<h1>Willkommen zurück</h1>
<p>Melden Sie sich bei Ihrem <?= _get('app.name') ?> Konto an</p>
<label>E-Mail-Adresse</label>
<label>Passwort</label>
<input placeholder="ihre@email.de">
<input placeholder="••••••••">
<span>Angemeldet bleiben</span>
<a href="#">Passwort vergessen?</a>
<button>Bei Ihrem Konto anmelden</button>
<span>Oder weiter mit</span>
<p>Noch kein Konto? <a href="#">Kostenlos registrieren</a></p>
<a href="/">Zurück zur Webseite</a>
```

### Security Features:
✅ **bcrypt Password Hashing**: Sichere Passwort-Speicherung  
✅ **Session Security**: HTTPOnly, Secure, SameSite Cookie-Attributes  
✅ **CSRF Protection**: Session-Token für Cross-Site Request Forgery Schutz  
✅ **Session Regeneration**: Schutz vor Session Fixation Attacken  
✅ **Input Sanitization**: Filter und Validierung aller Eingaben  
✅ **Auto-Logout**: Sichere Session-Zerstörung mit Cookie-Cleanup  

### Development Tools:
- **User Debug Interface**: `/debug/users` - Alle verfügbaren Accounts anzeigen
- **Session Inspector**: Aktuelle Session-Daten und User-Informationen
- **Password Hash Generator**: Tool für bcrypt-Hash-Generierung
- **Permission Testing**: Berechtigungs-Prüfung in Development-Mode

### Authentication Routes:
```php
['GET',  '/login',       'LoginController.showLogin'],      // Smart Login Display
['POST', '/login',       'LoginController.authenticate'],   // Login Processing
['GET',  '/logout',      'LoginController.logout'],         // Secure Logout
['GET',  '/dashboard',   'view.admin/dashboard', ['auth']], // Protected Dashboard
['GET',  '/debug/users', 'LoginController.listUsers'],      // Development Tool
```



## Task #3: Asset Management & Development Environment - 2. Oktober 2025

Implementierung eines modernen Asset-Management-Systems mit Vite, Tailwind CSS und Development-Environment:

### Implementierte Features:
- **Vite 7.1.8 Integration**: Modern JavaScript/CSS Build Tool für Development und Production
- **Tailwind CSS v4**: Neueste Version mit @tailwindcss/postcss Plugin
- **Asset Helper System**: Automatisches Dev/Production Switching für optimale Performance
- **Development Environment**: Vollständiges Setup mit brickpage.test Domain
- **Global Config Helper**: _get(), _has() und Helper-Funktionen für saubere Template-Syntax
- **Dot-Notation Support**: Strukturierte Konfiguration mit verschachtelten Arrays

### Projektstruktur-Erweiterung:
```
app/assets/
├── css/app.css              - Tailwind CSS Einstiegspunkt
└── js/app.js               - JavaScript Einstiegspunkt
app/config/app.php          - Dot-Notation Konfiguration
src/core/
├── AssetHelper.php         - Dev/Prod Asset Management
└── Config.php              - Erweiterte Config-Klasse
src/
├── bootstrap.php           - Helper-Loading und Config-Init
└── helpers.php             - Globale Helper-Funktionen
package.json                - Node.js Dependencies
vite.config.js             - Vite Build-Konfiguration
tailwind.config.js         - Tailwind CSS Setup
postcss.config.js          - PostCSS Konfiguration
SETUP.md                   - Development Setup Guide
```

### Asset Management Features:
- **Development Mode**: 
  - Assets von Vite Dev Server (http://localhost:3000)
  - Hot Reload für CSS/JS Änderungen
  - CORS-Konfiguration für brickpage.test
- **Production Mode**:
  - Kompilierte Assets in public/src/
  - Manifest-basierte Asset-Loading
  - Optimierte und minimierte Dateien

### Development Environment:
```bash
# Vite Dev Server starten
npm run dev

# Production Build
npm run build

# Domain: http://brickpage.test
# Assets: http://localhost:3000 (dev) | /src/ (prod)
```

### Global Config Helper System:
```php
// Dot-Notation Konfiguration
'app' => [
    'name' => 'Brickpage',
    'version' => '1.0.0',
    'url' => 'http://brickpage.test'
],
'vite' => [
    'dev_server' => 'http://localhost:3000',
    'entry_point' => 'app/assets/js/app.js'
]

// Template-Verwendung
<?= _get('app.name') ?>           // "Brickpage"
<?= _get('vite.dev_server') ?>    // "http://localhost:3000"
<?= app_name() ?>                 // Shortcut für app.name
<?= is_dev() ?>                   // Development Mode Check
```

### Tailwind CSS Integration:
```css
/* app/assets/css/app.css */
@import "tailwindcss";

/* Custom Brick Framework Components */
@layer components {
  .brick-card { @apply bg-white border border-gray-200 rounded-lg p-6 shadow-sm; }
  .brick-button { @apply px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700; }
  .brick-container { @apply container mx-auto px-4; }
}
```

### Asset Helper Funktionalität:
```php
// Automatisches Asset Loading
<?= AssetHelper::viteAssets() ?>

// Development Output:
<script type="module" src="http://localhost:3000/@vite/client"></script>
<script type="module" src="http://localhost:3000/app/assets/js/app.js"></script>

// Production Output:
<link rel="stylesheet" href="/src/assets/app-[hash].css">
<script type="module" src="/src/assets/app-[hash].js"></script>
```

### Environment Setup:
- **Domain**: brickpage.test mit Hosts-Datei oder Laravel Valet
- **Webserver**: Apache/Nginx/Valet Konfiguration
- **Node.js**: Vite Development Server auf Port 3000
- **PHP**: Built-in Server oder lokaler Webserver

## Task #2: Middleware-System mit Registry - 2. Oktober 2025

Implementierung eines flexiblen Middleware-Systems mit String-Alias-Registry:

### Implementierte Features:
- **Middleware-Interface**: Standardisierte Middleware-Schnittstelle mit `handle()` Methode
- **MiddlewareRegistry**: Zentrale Registry für Middleware-Management mit String-Aliases
- **Route-spezifische Middlewares**: Mehrere Middleware pro Route mit einfacher String-Syntax
- **Request-Processing Chain**: Middlewares können Output erzeugen UND Flow weitergeben
- **Alias-System**: Benutzerfreundliche String-Aliases statt Klassen-Namen
- **Rückwärts-Kompatibilität**: Unterstützt sowohl String-Aliases als auch direkte Klassen-Namen
- **Type-Safety**: Vollständige Typisierung mit PHPDoc-Annotations

### Projektstruktur-Erweiterung:
```
src/middleware/              - Middleware-Implementierungen
src/core/Middleware.php      - Middleware-Interface
src/core/MiddlewareRegistry.php - Zentrale Middleware-Registry
```

### Middleware-Features:
- **Registry-basiert**: Zentrale Verwaltung aller Middlewares mit String-Aliases
- **Flexible Syntax**: 
  - `['auth', 'hello']` (String-Aliases, empfohlen)
  - `[AuthMiddleware::class]` (Klassen-Namen, kompatibel)
- **Mehrere Middlewares**: Einfache Array-Syntax für Middleware-Ketten
- **Flow-Kontrolle**: 
  - `null` Rückgabe = Flow geht weiter (Middleware → Handler/View)
  - `string` Rückgabe = Flow wird gestoppt (nur Middleware-Output)
- **Output-Chaining**: Middleware kann `echo` verwenden und trotzdem Flow weitergeben
- **Alias-Auflösung**: Automatische Konvertierung von String-Aliases zu Klassen
- **Fehlerbehandlung**: Detaillierte Fehlermeldungen für unbekannte Aliases

### Registry-System:
```php
// Vordefinierte Aliases
'auth' => AuthMiddleware::class,
'hello' => HelloMiddleware::class

// Neue Middleware registrieren
MiddlewareRegistry::register('cors', CorsMiddleware::class);
```

### Beispiel-Implementation:
```php
// Route mit mehreren Middlewares (String-Aliases)
['GET', '/admin', 'view.home', ['auth', 'hello']]

// Middleware mit Output + Flow-Weitergabe
echo "🔐 AuthMiddleware: Benutzer authentifiziert!<br>";
echo "🚀 HelloMiddleware hat zugeschlagen!<br>";
return null; // Flow geht weiter → View wird gerendert

// Ausführungsreihenfolge: auth → hello → view.home
```

## Task #1: PHP Mini-Framework Grundstruktur - 1. Oktober 2025

In diesem ersten Task wurde eine grundlegende PHP-Framework-Struktur aufgebaut:

### Implementierte Features:
- **PSR-4 Autoloading**: Composer-basiertes Autoloading mit `Brick\` Namespace
- **Router-System**: Flexible Routing-Engine mit Unterstützung für HTTP-Methoden und URIs
- **View-System**: Template-Rendering mit PHP-Views
- **MVC-Architektur**: Klare Trennung von App, Router und View-Komponenten
- **Bootstrap-System**: Zentraler Einstiegspunkt mit Konstanten-Definition

### Projektstruktur:
```
app/config/routes.php - Routing-Konfiguration
app/views/           - View-Templates
src/core/            - Framework-Kernklassen (App, Router, View)
src/bootstrap.php    - Application Bootstrap
public/index.php     - Web-Einstiegspunkt
```

### Aktueller Funktionsumfang:
- Route-Definition über Konfigurations-Array
- Automatisches Controller-Loading und Method-Dispatching
- Fallback auf View-Rendering für einfache Templates
- 404-Fehlerbehandlung
- Saubere Namespacing-Struktur

