# Brick Framework - Development Setup

## Domain Setup für brickpage.test

### 1. Hosts-Datei konfigurieren
```bash
# /etc/hosts editieren
sudo nano /etc/hosts

# Diese Zeile hinzufügen:
127.0.0.1   brickpage.test
```

### 2. Webserver konfigurieren

#### Option A: Apache Virtual Host
```apache
<VirtualHost *:80>
    ServerName brickpage.test
    DocumentRoot /Users/jp.behrens/Workspace/brickpage/public
    
    <Directory /Users/jp.behrens/Workspace/brickpage/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Option B: Nginx
```nginx
server {
    listen 80;
    server_name brickpage.test;
    root /Users/jp.behrens/Workspace/brickpage/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### Option C: Laravel Valet (empfohlen für macOS)
```bash
# Valet installieren (falls nicht vorhanden)
composer global require laravel/valet
valet install

# Im Projekt-Ordner
cd /Users/jp.behrens/Workspace/brickpage
valet link brickpage

# Jetzt ist http://brickpage.test verfügbar
```

### 3. Development Server starten

```bash
# Terminal 1: Vite Dev Server
npm run dev

# Domain ist jetzt verfügbar unter:
# http://brickpage.test (App)
# http://localhost:3000 (Vite Dev Server für Assets)
```

### 4. Asset-Modi

#### Development Mode
- URL: http://brickpage.test
- Assets von: http://localhost:3000 (Vite Dev Server)
- Hot Reload: ✅ Aktiv für CSS/JS

#### Production Mode
- URL: http://brickpage.test  
- Assets von: /src/assets/ (kompilierte Dateien)
- Hot Reload: ❌ Deaktiviert

## Environment-Konfiguration

```php
// app/config/app.php
'url' => 'http://brickpage.test',

// Development Mode
'dev_mode' => true,

// Production Mode  
'dev_mode' => false,
```

## Troubleshooting

### Domain nicht erreichbar
1. Hosts-Datei prüfen: `cat /etc/hosts | grep brickpage`
2. DNS-Cache leeren: `sudo dscacheutil -flushcache`
3. Browser-Cache leeren

### Assets werden nicht geladen
1. Vite Dev Server läuft? `http://localhost:3000`
2. CORS-Konfiguration prüfen
3. Browser-Konsole auf Fehler prüfen