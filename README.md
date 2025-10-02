# brickpage

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

