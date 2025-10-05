# 🛠️ Brickpage Environment Management

Automatische Konfigurationsverwaltung für Development und Production Modi.

## 📋 Übersicht

Diese Skripte ermöglichen es, automatisch zwischen Development- und Production-Einstellungen in der `app/config/app.php` zu wechseln.

## 🚀 Verwendung

### NPM Scripts (Empfohlen)

```bash
# Development-Modus + Vite Dev Server starten
npm run dev

# Production-Modus + Vite Build
npm run build

# Nur Konfiguration ändern (ohne Vite)
npm run config:dev   # Development-Modus
npm run config:prod  # Production-Modus
```

### Direkte Skript-Verwendung

```bash
# Environment Manager (interaktiv)
./scripts/env-manager.sh [dev|prod|status|restore|help]

# Einzelne Skripte
./scripts/set-dev-mode.sh   # Development aktivieren
./scripts/set-prod-mode.sh  # Production aktivieren
```

## ⚙️ Was wird geändert

### Development-Modus (`npm run dev`)
```php
'env' => 'development',
'debug' => true,
'dev_mode' => true,
```

### Production-Modus (`npm run build`)
```php
'env' => 'production',
'debug' => false,
'dev_mode' => false,
```

## 🔧 Environment Manager Befehle

| Befehl | Beschreibung |
|--------|-------------|
| `dev` | Development-Modus aktivieren |
| `prod` | Production-Modus aktivieren |
| `status` | Aktuelle Konfiguration anzeigen |
| `restore` | Backup wiederherstellen |
| `help` | Hilfe anzeigen |

## 📁 Dateien

```
scripts/
├── env-manager.sh      # Hauptskript für Environment-Management
├── set-dev-mode.sh     # Development-Modus aktivieren
├── set-prod-mode.sh    # Production-Modus aktivieren
└── README.md           # Diese Dokumentation
```

## 🔒 Sicherheit

- Automatische Backups vor jeder Änderung
- Kompatibel mit macOS und Linux
- Validierung der Konfigurationsdatei

## 💡 Beispiele

```bash
# Status prüfen
./scripts/env-manager.sh status

# Zu Development wechseln
./scripts/env-manager.sh dev

# Zu Production wechseln und Build starten
npm run build

# Backup wiederherstellen
./scripts/env-manager.sh restore
```

## 🐛 Troubleshooting

### Skript nicht ausführbar
```bash
chmod +x scripts/*.sh
```

### Konfigurationsdatei nicht gefunden
Stellen Sie sicher, dass `app/config/app.php` existiert.

### Backup wiederherstellen
```bash
./scripts/env-manager.sh restore
```

---

*Erstellt für Brickpage v1.0.0*