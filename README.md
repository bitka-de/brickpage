# brickpage

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

