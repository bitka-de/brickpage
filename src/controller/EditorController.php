<?php

declare(strict_types=1);

namespace Brick\Controller;

use Brick\Core\Editor;
use Exception;

class EditorController
{
  public function renderView(): void
  {
    // Hier würde die Logik zum Rendern der View basierend auf der Anfrage stehen.
    var_dump($_GET);

    $view = $_GET['view'] ?? 'default';
    echo "EditorController: Render View";
  }

  public function view(string $viewName): void
  {
    // Convert colon-separated view names back to slash-separated paths
    $viewName = str_replace(':', '/', $viewName);

    // Validierung des View-Namens
    if (empty($viewName)) {
      http_response_code(400);
      echo "Error: View-Name ist erforderlich";
      return;
    }

    // Sicherheitsüberprüfung: Nur erlaubte Zeichen
    if (!preg_match('/^[a-zA-Z0-9\/_-]+$/', $viewName)) {
      http_response_code(400);
      echo "Error: Ungültiger View-Name. Nur Buchstaben, Zahlen, Bindestriche, Unterstriche und Schrägstriche sind erlaubt.";
      return;
    }

    // View-Pfad konstruieren
    $viewPath = VIEW_DIR . '/' . $viewName . '.php';

    // Prüfen ob View-Datei existiert
    if (!file_exists($viewPath)) {
      http_response_code(404);
      echo "Error: View '{$viewName}.php' nicht gefunden.";
      return;
    }

    // Quellcode der View-Datei lesen und Editor anzeigen
    try {
      $sourceCode = file_get_contents($viewPath);

      $editor = new Editor();
      // HTML für Split-View Editor mit Vorschau

      $viewPath = explode('/app/views/', $viewPath)[1] ?? $viewPath;

      echo $editor->htmlHeader($viewName) . '
<body>
    <div class="header">
        <h1 class="editor-headline">
            <a href="/'.ADMIN_DASHBOARD.'" title="Zurück zum Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cuboid-icon lucide-cuboid"><path d="m21.12 6.4-6.05-4.06a2 2 0 0 0-2.17-.05L2.95 8.41a2 2 0 0 0-.95 1.7v5.82a2 2 0 0 0 .88 1.66l6.05 4.07a2 2 0 0 0 2.17.05l9.95-6.12a2 2 0 0 0 .95-1.7V8.06a2 2 0 0 0-.88-1.66Z"/><path d="M10 22v-8L2.25 9.15"/><path d="m10 14 11.77-6.87"/></svg>
            </a>
        ' . htmlspecialchars($viewName) . '
        </h1>
        <div class="header-info">
            <span>Pfad: /app/views/' . htmlspecialchars($viewPath) . '</span>
            <span id="file-size" class="badge" style="background:#f5f7fa;color:#334155;border:1px solid rgba(15,23,42,0.06);border-radius:999px;padding:4px 8px;font-size:12px;display:inline-flex;align-items:center;gap:8px;box-shadow:0 1px 0 rgba(0,0,0,0.02);">📦 ' . number_format(strlen($sourceCode) / 1024, 2) . ' KB</span>
        </div>
    </div>
    <div class="toolbar">
        <button class="btn" onclick="saveFile()" id="save-btn">
            💾 Speichern (Strg+S)
        </button>
        <button class="btn btn-secondary" onclick="reloadFile()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw-icon lucide-refresh-cw"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg> Neu laden
        </button>
        <button class="btn btn-toggle" onclick="togglePreview()" id="preview-btn">
            👁️ Vorschau
        </button>
        <button class="btn btn-secondary" onclick="goBack()">
            ← Zurück zum Dashboard
        </button>
        <div class="status" id="status">Bereit</div>
    </div>
    
    <div class="split-container">
        <div class="editor-panel">
            <textarea id="code-editor">' . htmlspecialchars($sourceCode) . '</textarea>
        </div>
        
        <div class="splitter">
            <div class="resize-handle"></div>
        </div>
        
        <div class="preview-panel">
            <div class="preview-header">
                <span class="preview-title">🔍 Live-Vorschau</span>
                <div class="viewport-buttons">
                    <button class="viewport-btn active" onclick="setViewport(\'desktop\')" id="viewport-desktop">
                        🖥️ Desktop
                    </button>
                    <button class="viewport-btn" onclick="setViewport(\'tablet\')" id="viewport-tablet">
                        📱 Tablet
                    </button>
                    <button class="viewport-btn" onclick="setViewport(\'mobile\')" id="viewport-mobile">
                        📱 Mobile
                    </button>
                    <span class="viewport-info" id="viewport-info">1200px</span>
                </div>
                <button class="btn btn-secondary" onclick="refreshPreview()" style="font-size: 12px; padding: 4px 8px;">
                    🔄 Aktualisieren
                </button>
            </div>
            <div class="preview-content">
                <div class="preview-loading" id="preview-loading">
                    Vorschau wird geladen...
                </div>
                <iframe class="preview-iframe" id="preview-iframe" style="display: none;"></iframe>
            </div>
        </div>
    </div>

    ' . $editor->footerScript($viewName) . '
</body>
</html>';
    } catch (Exception $e) {
      http_response_code(500);
      echo "Error beim Lesen der View-Datei: " . htmlspecialchars($e->getMessage());
    }
  }

  public function preview(string $viewName): void
  {
    // Convert colon-separated view names back to slash-separated paths
    $viewName = str_replace(':', '/', $viewName);

    // Nur POST-Requests akzeptieren
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      header('Content-Type: application/json');
      echo json_encode(['error' => 'Nur POST-Requests erlaubt']);
      return;
    }

    try {
      // JSON-Daten aus Request Body lesen
      $input = file_get_contents('php://input');
      $data = json_decode($input, true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Ungültige JSON-Daten']);
        return;
      }

      if (!isset($data['content'])) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Content-Parameter fehlt']);
        return;
      }

      $content = $data['content'];

      // Temporäre Datei für Vorschau erstellen
      $tempFile = tempnam(sys_get_temp_dir(), 'preview_' . str_replace('/', '_', $viewName) . '_');
      $tempPhpFile = $tempFile . '.php';

      // Temp-Datei mit Inhalt befüllen
      file_put_contents($tempPhpFile, $content);

      // PHP-Content direkt ausführen und ausgeben
      ob_start();

      // Fehler-Reporting für die Vorschau anpassen
      $old_error_reporting = error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
      $old_display_errors = ini_get('display_errors');
      ini_set('display_errors', 0);

      try {
        // Globale Variablen für Views verfügbar machen
        extract($_GLOBALS ?? []);

        // View inkludieren
        include $tempPhpFile;
      } catch (Exception $e) {
        // Bei Fehlern eine Fehlerseite anzeigen
        echo '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vorschau-Fehler</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #ffe6e6; }
        .error { background: #ffcccc; border: 2px solid #ff6666; padding: 20px; border-radius: 5px; }
        .error h2 { color: #cc0000; margin: 0 0 10px 0; }
        .error pre { background: #fff; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="error">
        <h2>🚨 Vorschau-Fehler</h2>
        <p><strong>Fehler in der View:</strong></p>
        <pre>' . htmlspecialchars($e->getMessage()) . '</pre>
        <p><strong>Datei:</strong> ' . htmlspecialchars($viewName) . '.php</p>
        <p><em>Überprüfe den Code auf Syntax-Fehler und speichere die Datei, um die Vorschau zu aktualisieren.</em></p>
    </div>
</body>
</html>';
      }

      // Error-Reporting zurücksetzen
      error_reporting($old_error_reporting);
      ini_set('display_errors', $old_display_errors);

      $output = ob_get_clean();

      // Temporäre Datei löschen
      unlink($tempPhpFile);
      unlink($tempFile);

      // HTML-Content direkt ausgeben
      header('Content-Type: text/html; charset=utf-8');
      echo $output;
    } catch (Exception $e) {
      http_response_code(500);
      header('Content-Type: text/html; charset=utf-8');
      echo '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vorschau nicht verfügbar</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; margin: 20px; background: #f8f9fa; }
        .message { background: #e9ecef; border: 1px solid #dee2e6; padding: 20px; border-radius: 5px; text-align: center; }
    </style>
</head>
<body>
    <div class="message">
        <h2>⚠️ Vorschau nicht verfügbar</h2>
        <p>Die Vorschau konnte nicht erstellt werden.</p>
        <p><small>Fehler: ' . htmlspecialchars($e->getMessage()) . '</small></p>
    </div>
</body>
</html>';
    }
  }

  public function save(string $viewName): void
  {
    // Convert colon-separated view names back to slash-separated paths
    $viewName = str_replace(':', '/', $viewName);

    // Nur POST-Requests akzeptieren
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      header('Content-Type: application/json');
      echo json_encode(['error' => 'Nur POST-Requests erlaubt']);
      return;
    }

    // Validierung des View-Namens
    if (empty($viewName)) {
      http_response_code(400);
      header('Content-Type: application/json');
      echo json_encode(['error' => 'View-Name ist erforderlich']);
      return;
    }

    // Sicherheitsüberprüfung: Nur erlaubte Zeichen
    if (!preg_match('/^[a-zA-Z0-9\/_-]+$/', $viewName)) {
      http_response_code(400);
      header('Content-Type: application/json');
      echo json_encode(['error' => 'Ungültiger View-Name']);
      return;
    }

    // View-Pfad konstruieren
    $viewPath = VIEW_DIR . '/' . $viewName . '.php';

    // Prüfen ob View-Datei existiert
    if (!file_exists($viewPath)) {
      http_response_code(404);
      header('Content-Type: application/json');
      echo json_encode(['error' => "View '{$viewName}.php' nicht gefunden"]);
      return;
    }

    try {
      // JSON-Daten aus Request Body lesen
      $input = file_get_contents('php://input');
      $data = json_decode($input, true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Ungültige JSON-Daten']);
        return;
      }

      if (!isset($data['content'])) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Content-Parameter fehlt']);
        return;
      }

      $content = $data['content'];

      // Organisiertes Backup-System mit automatischer Bereinigung
      $backupDir = dirname(dirname(dirname(__FILE__))) . '/app/backup/views';

      // Backup-Verzeichnis erstellen falls nicht vorhanden
      if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
      }

      // Relativen View-Pfad für Backup-Struktur ermitteln
      $relativePath = str_replace(VIEW_DIR . '/', '', $viewPath);
      $backupSubDir = $backupDir . '/' . dirname($relativePath);

      // Backup-Unterverzeichnis erstellen
      if (!is_dir($backupSubDir)) {
        mkdir($backupSubDir, 0755, true);
      }

      // Backup-Dateiname mit Zeitstempel
      $fileName = basename($relativePath, '.php');
      $backupFileName = $fileName . '_' . date('Y-m-d_H-i-s') . '.php';
      $backupPath = $backupSubDir . '/' . $backupFileName;

      // Backup erstellen
      if (file_exists($viewPath)) {
        copy($viewPath, $backupPath);
      }

      // Alte Backups bereinigen (nur die letzten 5 behalten)
      $this->cleanupBackups($backupSubDir, $fileName, 5);

      // Neue Inhalte in die Datei schreiben
      $bytesWritten = file_put_contents($viewPath, $content, LOCK_EX);

      if ($bytesWritten === false) {
        // Backup wiederherstellen wenn Schreibvorgang fehlschlägt
        if (file_exists($backupPath)) {
          copy($backupPath, $viewPath);
          unlink($backupPath);
        }

        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Fehler beim Schreiben der Datei']);
        return;
      }

      // Erfolgreiche Antwort mit Backup-Info
      header('Content-Type: application/json');
      echo json_encode([
        'success' => true,
        'message' => 'Datei erfolgreich gespeichert',
        'bytes_written' => $bytesWritten,
        'timestamp' => date('Y-m-d H:i:s'),
        'backup_created' => $backupPath,
        'backup_location' => 'app/backup/views/'
      ]);
    } catch (Exception $e) {
      http_response_code(500);
      header('Content-Type: application/json');
      echo json_encode(['error' => 'Fehler beim Speichern: ' . $e->getMessage()]);
    }
  }

  /**
   * Bereinigt alte Backups und behält nur die neuesten N Dateien
   */
  private function cleanupBackups(string $backupDir, string $fileName, int $maxBackups): void
  {
    if (!is_dir($backupDir)) {
      return;
    }

    // Alle Backup-Dateien für diese View finden
    $pattern = $backupDir . '/' . $fileName . '_*.php';
    $backupFiles = glob($pattern);

    if (count($backupFiles) <= $maxBackups) {
      return; // Nichts zu bereinigen
    }

    // Nach Änderungszeit sortieren (neueste zuerst)
    usort($backupFiles, function ($a, $b) {
      return filemtime($b) - filemtime($a);
    });

    // Alte Backups löschen (alles nach den ersten maxBackups)
    $filesToDelete = array_slice($backupFiles, $maxBackups);
    foreach ($filesToDelete as $file) {
      if (file_exists($file)) {
        unlink($file);
      }
    }
  }
}
