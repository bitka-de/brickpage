# brickpage

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

