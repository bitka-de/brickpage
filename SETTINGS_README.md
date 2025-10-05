# Settings Editor - Dokumentation

## Übersicht

Der Settings Editor ermöglicht es Administratoren, die Website-Einstellungen direkt über eine benutzerfreundliche Web-Oberfläche zu bearbeiten.

## Funktionen

### 1. Website-Grunddaten
- Website-Name
- Tagline  
- Domain
- Sprache

### 2. Design & Theme
- Template-Auswahl
- Schriftart
- Primärfarbe (mit Farbwähler)
- Sekundärfarbe (mit Farbwähler)

### 3. Navigation
- Dynamische Menüpunkte hinzufügen/entfernen
- Label und Pfad für jeden Menüpunkt
- Drag & Drop Sortierung (JavaScript)

### 4. Integrationen
- Google Analytics Konfiguration
- E-Mail Marketing (Mailchimp/SendGrid)

## Verwendung

### Zugriff
Nach dem Login als Administrator: `/settings`

### Bearbeitung
1. Gewünschte Felder bearbeiten
2. "Einstellungen speichern" klicken
3. Erfolgsmeldung wird angezeigt

### Navigation verwalten
- "Navigation hinzufügen" für neue Menüpunkte
- Papierkorb-Icon zum Löschen
- Felder: Label (Anzeigename) und Pfad (URL)

## Technische Details

### Dateien
- **Controller**: `src/Controller/SettingsController.php`
- **View**: `app/views/admin/settings.php`
- **Config**: `app/config/settings.php`
- **Routen**: `app/config/routes.php`

### Routen
- `GET /settings` - Settings-Seite anzeigen
- `POST /settings/update` - Settings speichern

### Sicherheit
- Authentifizierung erforderlich (Auth-Middleware)
- Input-Validierung
- XSS-Schutz durch htmlspecialchars()

## Installation

Die Settings-Funktionalität ist vollständig implementiert und einsatzbereit!

### Navigation-Links
Die Navigation wurde um einen "Settings"-Link erweitert:
- Desktop: In der oberen Navigationsleiste
- Mobile: Im ausklappbaren Menü

### Abhängigkeiten
- TailwindCSS für Styling
- FontAwesome für Icons
- Vanilla JavaScript für dynamische Navigation

## Anpassungen

### Weitere Felder hinzufügen
1. In `settings.php` das neue Feld definieren
2. In der View das entsprechende Formularfeld hinzufügen
3. Im Controller die Validierung und Speicherung erweitern

### Styling anpassen
Die View verwendet TailwindCSS-Klassen und kann leicht angepasst werden.

### Validierung erweitern
Im SettingsController können zusätzliche Validierungsregeln hinzugefügt werden.