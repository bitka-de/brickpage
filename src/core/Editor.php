<?php

declare(strict_types=1);

namespace Brick\Core;

class Editor
{
  public function build($viewName = '?view'): string
  {
    return $this->htmlHeader($viewName);
  }


  public function htmlHeader(string $viewName): string
  {
    return '
<!DOCTYPE html>
  <html lang="de">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Editor: ' . htmlspecialchars($viewName) . '</title>
      ' . $this->scripts() . '
      ' . $this->styles() . '  
  </head>
    ';
  }

  private function scripts(): string
  {
    return '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/clike/clike.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">
    ';
  }

  private function styles(): string
  {
    return '
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background: #1e1e1e; 
            color: #fff; 
            overflow: hidden;
        }
        .header { 
            background: #2d2d30; 
            padding: 15px 20px; 
            border-bottom: 1px solid #3e3e42; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            position: relative;
            z-index: 100;
        }
        .header h1 { font-size: 18px; font-weight: 600; }
        .header-info { display: flex; align-items: center; gap: 20px; font-size: 14px; color: #cccccc; }
        .toolbar { 
            background: #37373d; 
            padding: 10px 20px; 
            border-bottom: 1px solid #3e3e42;
            display: flex;
            gap: 10px;
            align-items: center;
            position: relative;
            z-index: 100;
        }
        .btn { 
            background: #0e639c; 
            color: white; 
            border: none; 
            padding: 8px 16px; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s;
        }
        .btn:hover { background: #1177bb; }
        .btn:disabled { background: #666; cursor: not-allowed; }
        .btn-secondary { background: #5a5a5a; }
        .btn-secondary:hover { background: #6a6a6a; }
        .btn-toggle { background: #16537e; }
        .btn-toggle.active { background: #0e639c; box-shadow: inset 0 2px 4px rgba(0,0,0,0.3); }
        .status { 
            margin-left: auto; 
            padding: 4px 8px; 
            background: #252526; 
            border-radius: 3px; 
            font-size: 12px;
            color: #cccccc;
        }
        .split-container { 
            height: calc(100vh - 120px); 
            display: flex;
            position: relative;
            background: #1e1e1e;
        }
        .editor-panel { 
            flex: 0 0 60%;
            min-width: 300px;
            background: #1e1e1e;
            position: relative;
        }
        .splitter { 
            width: 6px; 
            background: #3e3e42; 
            cursor: col-resize; 
            position: relative;
            flex-shrink: 0;
            transition: background 0.2s;
            z-index: 10;
        }
        .splitter:hover { background: #007acc; }
        .splitter::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 2px;
            height: 30px;
            background: #666;
            border-radius: 1px;
            pointer-events: none;
        }
        .splitter:hover::before {
            background: #fff;
        }
        .preview-panel { 
            flex: 1;
            min-width: 200px;
            background: #ffffff;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .preview-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 6px 12px;
            font-size: 13px;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            min-height: 40px;
        }
        .preview-title {
            font-weight: 600;
            margin-right: auto;
            flex-shrink: 0;
            font-size: 13px;
        }
        .viewport-buttons {
            display: flex;
            gap: 3px;
            align-items: center;
            flex-wrap: wrap;
        }
        .viewport-btn {
            background: #e9ecef;
            color: #495057;
            border: 1px solid #ced4da;
            padding: 3px 6px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 10px;
            font-weight: 500;
            transition: all 0.2s;
            min-width: 50px;
            text-align: center;
            white-space: nowrap;
        }
        .viewport-btn:hover {
            background: #dee2e6;
        }
        .viewport-btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .viewport-info {
            font-size: 9px;
            color: #6c757d;
            margin-left: 3px;
            white-space: nowrap;
        }
        
        /* Responsive Anpassungen für Preview-Header */
        @media (max-width: 500px) {
            .preview-header {
                padding: 4px 8px;
                gap: 4px;
                flex-direction: column;
                align-items: stretch;
            }
            .preview-title {
                font-size: 12px;
                text-align: center;
                margin-right: 0;
            }
            .viewport-buttons {
                justify-content: center;
                gap: 2px;
            }
            .viewport-btn {
                font-size: 9px;
                padding: 2px 4px;
                min-width: 40px;
            }
            .viewport-info {
                font-size: 8px;
            }
        }
        
        /* Anpassungen für schmale Preview-Panels */
        .preview-panel[data-width="narrow"] .preview-header {
            padding: 4px 6px;
            flex-direction: column;
            gap: 4px;
        }
        .preview-panel[data-width="narrow"] .preview-title {
            font-size: 11px;
            margin-right: 0;
            text-align: center;
        }
        .preview-panel[data-width="narrow"] .viewport-buttons {
            justify-content: center;
            gap: 2px;
        }
        .preview-panel[data-width="narrow"] .viewport-btn {
            font-size: 9px;
            padding: 2px 4px;
            min-width: 35px;
        }
        .preview-panel[data-width="narrow"] .viewport-info {
            font-size: 7px;
        }
        .preview-panel[data-width="narrow"] .btn {
            font-size: 10px;
            padding: 2px 4px;
            min-width: auto;
        }
        
        /* Für extrem schmale Panels (unter 300px) */
        .preview-panel[data-width="extra-narrow"] .preview-header {
            padding: 2px 4px;
        }
        .preview-panel[data-width="extra-narrow"] .preview-title {
            font-size: 10px;
        }
        .preview-panel[data-width="extra-narrow"] .viewport-btn {
            font-size: 8px;
            padding: 1px 2px;
            min-width: 30px;
        }
        .preview-panel[data-width="extra-narrow"] .btn {
            display: none; /* Refresh-Button verstecken bei sehr schmalen Panels */
        }
        .preview-content {
            flex: 1;
            position: relative;
            overflow: hidden;
        }
        .preview-iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }
        .preview-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #6c757d;
            font-size: 14px;
        }
        .CodeMirror { 
            height: 100%; 
            font-family: "Monaco", "Menlo", "Ubuntu Mono", monospace; 
            font-size: 14px;
        }
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 500;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }
        .toast.show { transform: translateX(0); }
        .toast.success { background: #16a34a; color: white; }
        .toast.error { background: #dc2626; color: white; }
        .resize-handle {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 10px;
            margin-left: -5px;
            cursor: col-resize;
            z-index: 10;
        }
        .preview-disabled {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #6c757d;
            font-size: 14px;
            text-align: center;
            line-height: 1.5;
        }

        .editor-headline {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 600;
        }

        .editor-headline a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .editor-headline a svg {
            width: 2rem;
            height: 2rem;
            flex-shrink: 0;
            stroke: #cccccc;
            background: rgba(0,0,0,0.3);
            padding: 4px;
            border-radius: 6px;
        }

        
    </style>
    ';
  }

  public function footerScript(string $viewName): string
  {
    return '
        <script>
        // CodeMirror Editor initialisieren
        const editor = CodeMirror.fromTextArea(document.getElementById("code-editor"), {
            mode: "application/x-httpd-php",
            theme: "monokai",
            lineNumbers: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            indentUnit: 2,
            indentWithTabs: false,
            lineWrapping: true,
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
        });

        let hasUnsavedChanges = false;
        let originalContent = editor.getValue();
        let previewEnabled = true;
        let previewTimeout = null;
        let isResizing = false;
        let currentViewport = "desktop";

        // Viewport-Größen definieren
        const viewportSizes = {
            desktop: { 
                width: "100%", 
                label: "Desktop", 
                info: "1200px+",
                previewPanelWidth: "40vw"   // 40vw für Desktop-Preview
            },
            tablet: { 
                width: "768px", 
                label: "Tablet", 
                info: "768px",
                previewPanelWidth: "768px"  // Feste 768px für Tablet-Preview
            },
            mobile: { 
                width: "375px", 
                label: "Mobile", 
                info: "375px",
                previewPanelWidth: "375px"  // Feste 375px für Mobile-Preview
            }
        };

        // Split-Panel Elemente
        const splitContainer = document.querySelector(".split-container");
        const editorPanel = document.querySelector(".editor-panel");
        const splitter = document.querySelector(".splitter");
        const previewPanel = document.querySelector(".preview-panel");
        const previewIframe = document.getElementById("preview-iframe");
        const previewLoading = document.getElementById("preview-loading");

        function initSplitter() {
            splitter.addEventListener("mousedown", startDrag);
            document.addEventListener("mousemove", drag);
            document.addEventListener("mouseup", endDrag);
        }

        let isDragging = false;
        let startX = 0;
        let startEditorWidth = 0;

        function startDrag(e) {
            e.preventDefault();
            isDragging = true;
            isResizing = true;
            startX = e.clientX;
            startEditorWidth = editorPanel.offsetWidth;
            
            // Cursor und Selection für gesamtes Dokument setzen
            document.body.style.cursor = "col-resize";
            document.body.style.userSelect = "none";
            document.body.style.webkitUserSelect = "none";
            document.body.style.mozUserSelect = "none";
            
            // Overlay für besseres Dragging
            if (!document.getElementById("drag-overlay")) {
                const overlay = document.createElement("div");
                overlay.id = "drag-overlay";
                overlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100vw;
                    height: 100vh;
                    z-index: 9999;
                    cursor: col-resize;
                    user-select: none;
                    background: transparent;
                `;
                document.body.appendChild(overlay);
            }
        }

        function drag(e) {
            if (!isDragging) return;
            
            e.preventDefault();
            const deltaX = e.clientX - startX;
            const containerWidth = splitContainer.offsetWidth;
            const splitterWidth = 6; // Splitter Breite
            
            let newEditorWidth = startEditorWidth + deltaX;
            const minEditorWidth = 300;
            const minPreviewWidth = 200;
            const maxEditorWidth = containerWidth - splitterWidth - minPreviewWidth;
            
            // Grenzen einhalten
            newEditorWidth = Math.max(minEditorWidth, Math.min(newEditorWidth, maxEditorWidth));
            
            // Neue Breite setzen
            editorPanel.style.flex = `0 0 ${newEditorWidth}px`;
            
            // Vorschau-Panel bekommt den Rest
            const remainingWidth = containerWidth - newEditorWidth - splitterWidth;
            previewPanel.style.flex = `0 0 ${remainingWidth}px`;
        }

        function endDrag() {
            if (!isDragging) return;
            
            isDragging = false;
            isResizing = false;
            
            // Cursor und Selection zurücksetzen
            document.body.style.cursor = "";
            document.body.style.userSelect = "";
            document.body.style.webkitUserSelect = "";
            document.body.style.mozUserSelect = "";
            
            // Overlay entfernen
            const overlay = document.getElementById("drag-overlay");
            if (overlay) {
                overlay.remove();
            }
            
            // CodeMirror nach dem Resize aktualisieren
            setTimeout(() => {
                editor.refresh();
                updatePreviewHeaderLayout();
            }, 100);
        }

        // Viewport umschalten
        function setViewport(type) {
            currentViewport = type;
            const viewport = viewportSizes[type];
            
            // Button-States aktualisieren
            document.querySelectorAll(".viewport-btn").forEach(btn => btn.classList.remove("active"));
            document.getElementById("viewport-" + type).classList.add("active");
            
            // Info aktualisieren
            document.getElementById("viewport-info").textContent = viewport.info;
            
            // Preview-Panel-Breite anpassen (das ist der wichtige Teil!)
            const containerWidth = splitContainer.offsetWidth;
            const splitterWidth = 6;
            
            let newPreviewWidth;
            if (viewport.previewPanelWidth.includes("%")) {
                const percentage = parseFloat(viewport.previewPanelWidth) / 100;
                newPreviewWidth = containerWidth * percentage;
            } else if (viewport.previewPanelWidth.includes("vw")) {
                const vwValue = parseFloat(viewport.previewPanelWidth);
                newPreviewWidth = (window.innerWidth * vwValue) / 100;
            } else {
                newPreviewWidth = parseInt(viewport.previewPanelWidth);
            }
            
            // Grenzen einhalten
            const minPreviewWidth = 200;
            const minEditorWidth = 300;
            const maxPreviewWidth = containerWidth - splitterWidth - minEditorWidth;
            
            newPreviewWidth = Math.max(minPreviewWidth, Math.min(newPreviewWidth, maxPreviewWidth));
            
            // Panel-Größen animiert anpassen
            previewPanel.style.transition = "flex 0.3s ease";
            editorPanel.style.transition = "flex 0.3s ease";
            
            previewPanel.style.flex = "0 0 " + newPreviewWidth + "px";
            
            const remainingWidth = containerWidth - newPreviewWidth - splitterWidth;
            editorPanel.style.flex = "0 0 " + remainingWidth + "px";
            
            // Transition nach Animation entfernen
            setTimeout(() => {
                previewPanel.style.transition = "";
                editorPanel.style.transition = "";
            }, 300);
            
            // Iframe immer 100% des Preview-Panels
            previewIframe.style.width = "100%";
            previewIframe.style.maxWidth = "none";
            previewIframe.style.margin = "0";
            
            // CodeMirror nach Viewport-Wechsel aktualisieren
            setTimeout(() => {
                editor.refresh();
                updatePreviewHeaderLayout();
            }, 350);
        }

        // Preview-Header Layout dynamisch anpassen
        function updatePreviewHeaderLayout() {
            const previewPanelWidth = previewPanel.offsetWidth;
            
            // Schwellwerte für schmale Panels definieren
            if (previewPanelWidth < 300) {
                previewPanel.setAttribute("data-width", "extra-narrow");
            } else if (previewPanelWidth < 400) {
                previewPanel.setAttribute("data-width", "narrow");
            } else {
                previewPanel.removeAttribute("data-width");
            }
        }

        // Änderungen verfolgen und Vorschau aktualisieren
        editor.on("change", function() {
            hasUnsavedChanges = (editor.getValue() !== originalContent);
            updateStatus();
            updateFileSize();
            
            // Debounced preview update
            if (previewEnabled && !isResizing) {
                clearTimeout(previewTimeout);
                previewTimeout = setTimeout(() => {
                    updatePreview();
                }, 1000); // 1 Sekunde Verzögerung
            }
        });

        // Status aktualisieren
        function updateStatus() {
            const status = document.getElementById("status");
            const saveBtn = document.getElementById("save-btn");
            
            if (hasUnsavedChanges) {
                status.textContent = "Ungespeicherte Änderungen";
                status.style.background = "#b45309";
                saveBtn.textContent = "💾 Speichern* (Strg+S)";
            } else {
                status.textContent = "Bereit";
                status.style.background = "#252526";
                saveBtn.textContent = "💾 Speichern (Strg+S)";
            }
        }

        // Dateigröße aktualisieren
        function updateFileSize() {
            const size = new Intl.NumberFormat("de-DE").format(editor.getValue().length);
            document.getElementById("file-size").textContent = `Größe: ${size} Zeichen`;
        }

        // Toast-Benachrichtigung anzeigen
        function showToast(message, type = "success") {
            const existingToasts = document.querySelectorAll(".toast");
            existingToasts.forEach(toast => toast.remove());
            
            const toast = document.createElement("div");
            toast.className = "toast " + type;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.classList.add("show"), 100);
            setTimeout(() => {
                toast.classList.remove("show");
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Vorschau umschalten
        function togglePreview() {
            previewEnabled = !previewEnabled;
            const previewBtn = document.getElementById("preview-btn");
            
            if (previewEnabled) {
                previewPanel.style.display = "flex";
                splitter.style.display = "block";
                previewBtn.classList.add("active");
                editorPanel.style.flex = "0 0 60%";
                updatePreview();
            } else {
                previewPanel.style.display = "none";
                splitter.style.display = "none";
                previewBtn.classList.remove("active");
                editorPanel.style.flex = "1";
            }
            
            setTimeout(() => {
                editor.refresh();
            }, 100);
        }

        // Vorschau aktualisieren
        function updatePreview() {
            if (!previewEnabled) return;
            
            previewLoading.style.display = "block";
            previewIframe.style.display = "none";
            
            // Temporäre Datei für Vorschau erstellen
            const content = editor.getValue();
            
            fetch("/editor/preview/" + "' . str_replace('/', ':', $viewName) . '", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    content: content
                })
            })
            .then(response => {
                if (response.ok) {
                    return response.blob();
                }
                throw new Error("Preview-Fehler");
            })
            .then(blob => {
                const url = URL.createObjectURL(blob);
                previewIframe.src = url;
                previewIframe.onload = () => {
                    previewLoading.style.display = "none";
                    previewIframe.style.display = "block";
                    setViewport(currentViewport); // Viewport nach Laden anwenden
                    URL.revokeObjectURL(url);
                };
            })
            .catch(error => {
                previewLoading.textContent = "Vorschau nicht verfügbar";
                console.error("Preview error:", error);
            });
        }

        // Vorschau manuell aktualisieren
        function refreshPreview() {
            if (previewEnabled) {
                updatePreview();
                showToast("🔄 Vorschau aktualisiert", "success");
            }
        }

        // Datei speichern
        async function saveFile() {
            const saveBtn = document.getElementById("save-btn");
            const originalText = saveBtn.textContent;
            
            saveBtn.disabled = true;
            saveBtn.textContent = "💾 Speichere...";
            
            try {
                const response = await fetch("/editor/save/" + "' . str_replace('/', ':', $viewName) . '", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        content: editor.getValue()
                    })
                });
                
                if (response.ok) {
                    const result = await response.json();
                    hasUnsavedChanges = false;
                    originalContent = editor.getValue();
                    updateStatus();
                    showToast("✅ Datei erfolgreich gespeichert!", "success");
                    
                    // Vorschau nach dem Speichern aktualisieren
                    if (previewEnabled) {
                        setTimeout(() => updatePreview(), 500);
                    }
                } else {
                    const error = await response.text();
                    showToast("❌ Fehler beim Speichern: " + error, "error");
                }
            } catch (error) {
                showToast("❌ Netzwerkfehler: " + error.message, "error");
            } finally {
                saveBtn.disabled = false;
                saveBtn.textContent = originalText;
            }
        }

        // Datei neu laden
        async function reloadFile() {
            if (hasUnsavedChanges) {
                if (!confirm("Ungespeicherte Änderungen gehen verloren. Trotzdem neu laden?")) {
                    return;
                }
            }
            
            try {
                const response = await fetch("/editor/view/" + "' . str_replace('/', ':', $viewName) . '?reload=1");
                if (response.ok) {
                    location.reload();
                } else {
                    showToast("❌ Fehler beim Neu laden", "error");
                }
            } catch (error) {
                showToast("❌ Netzwerkfehler: " + error.message, "error");
            }
        }

        // Zurück zum Dashboard
        function goBack() {
            if (hasUnsavedChanges) {
                if (!confirm("Ungespeicherte Änderungen gehen verloren. Trotzdem zurückkehren?")) {
                    return;
                }
            }
            window.location.href = "/dashboard";
        }

        // Keyboard Shortcuts
        document.addEventListener("keydown", function(e) {
            if (e.ctrlKey || e.metaKey) {
                if (e.key === "s") {
                    e.preventDefault();
                    saveFile();
                } else if (e.key === "p") {
                    e.preventDefault();
                    togglePreview();
                } else if (e.key === "1") {
                    e.preventDefault();
                    setViewport("desktop");
                } else if (e.key === "2") {
                    e.preventDefault();
                    setViewport("tablet");
                } else if (e.key === "3") {
                    e.preventDefault();
                    setViewport("mobile");
                }
            }
        });

        // Warnung bei ungespeicherten Änderungen beim Verlassen der Seite
        window.addEventListener("beforeunload", function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = "";
                return "";
            }
        });

        // Window Resize Handler für responsive Split-Anpassung
        window.addEventListener("resize", function() {
            // Viewport-Einstellungen nach Resize neu anwenden
            setTimeout(() => {
                setViewport(currentViewport);
            }, 100);
        });

        // Editor initialisieren
        editor.focus();
        
        // Splitter initialisieren
        initSplitter();
        
        // Initiale Layout-Anpassung
        setTimeout(() => {
            updatePreviewHeaderLayout();
        }, 100);
        
        // Initiale Vorschau laden
        setTimeout(() => {
            updatePreview();
        }, 1000);
    </script>
    ';
  }
}
