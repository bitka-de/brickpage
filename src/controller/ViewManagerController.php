<?php

declare(strict_types=1);

namespace Brick\Controller;

class ViewManagerController
{
    private $viewsPath;
    
    public function __construct()
    {
        $this->viewsPath = __DIR__ . '/../../app/views/';
    }
    
    public function test()
    {
        echo "ViewManagerController funktioniert!";
    }
    
    public function listViews()
    {
        header('Content-Type: application/json');
        
        try {
            $views = $this->scanViewDirectory($this->viewsPath);
            $routes = $this->loadRoutes();
            
            // Map routes to views
            foreach ($views as &$view) {
                $view['routes'] = $this->findRoutesForView($view['name'], $routes);
            }
            
            echo json_encode(['success' => true, 'views' => $views]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Fehler beim Laden der Views: ' . $e->getMessage()]);
        }
    }
    
    public function deleteView()
    {
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                return;
            }
            
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            
            if (!$input || !isset($input['name'])) {
                http_response_code(400);
                echo json_encode(['error' => 'View name is required']);
                return;
            }
            
            $viewName = trim($input['name']);
            $filePath = $this->viewsPath . $viewName . '.php';
            
            if (!file_exists($filePath)) {
                http_response_code(404);
                echo json_encode(['error' => 'View "' . $viewName . '.php" existiert nicht']);
                return;
            }
            
            // Prevent deletion of critical views
            $protectedViews = ['admin/dashboard', 'auth/login', 'home'];
            if (in_array($viewName, $protectedViews)) {
                http_response_code(403);
                echo json_encode(['error' => 'Die View "' . $viewName . '.php" ist geschützt und kann nicht gelöscht werden']);
                return;
            }
            
            if (!unlink($filePath)) {
                http_response_code(500);
                echo json_encode(['error' => 'View konnte nicht gelöscht werden']);
                return;
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'View "' . $viewName . '.php" wurde erfolgreich gelöscht'
            ]);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Unerwarteter Fehler: ' . $e->getMessage()]);
        }
    }
    
    private function scanViewDirectory($directory, $prefix = '')
    {
        $views = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $relativePath = str_replace($directory, '', $file->getPathname());
                $relativePath = ltrim($relativePath, '/\\');
                $viewName = str_replace('.php', '', $relativePath);
                $viewName = str_replace('\\', '/', $viewName); // Windows compatibility
                
                $views[] = [
                    'name' => $viewName,
                    'file' => $relativePath,
                    'size' => $file->getSize(),
                    'modified' => date('d.m.Y H:i', $file->getMTime())
                ];
            }
        }
        
        // Sort by name
        usort($views, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        
        return $views;
    }
    
    public function createView()
    {
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                return;
            }
            
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            
            if (!$input || !isset($input['name']) || !isset($input['template'])) {
                http_response_code(400);
                echo json_encode(['error' => 'View name and template are required', 'received' => $input]);
                return;
            }
            
            $viewName = trim($input['name']);
            $template = $input['template'];
            
            // Validate view name
            if (!preg_match('/^[a-zA-Z0-9\/_-]+$/', $viewName)) {
                http_response_code(400);
                echo json_encode(['error' => 'View-Name darf nur Buchstaben, Zahlen, Bindestriche, Unterstriche und Schrägstriche enthalten']);
                return;
            }
            
            // Build file path
            $filePath = $this->viewsPath . $viewName . '.php';
            
            // Check if view already exists
            if (file_exists($filePath)) {
                http_response_code(409);
                echo json_encode(['error' => 'Eine View mit dem Namen "' . $viewName . '.php" existiert bereits']);
                return;
            }
            
            // Create directory if it doesn't exist
            $directory = dirname($filePath);
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0755, true)) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Ordner konnte nicht erstellt werden: ' . $directory]);
                    return;
                }
            }
            
            // Generate view content based on template
            $content = $this->generateViewContent($viewName, $template);
            
            // Create the view file
            if (file_put_contents($filePath, $content) === false) {
                http_response_code(500);
                echo json_encode(['error' => 'View-Datei konnte nicht erstellt werden: ' . $filePath]);
                return;
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'View "' . $viewName . '.php" wurde erfolgreich erstellt',
                'path' => $viewName
            ]);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Unerwarteter Fehler: ' . $e->getMessage()]);
        }
    }
    
    private function generateViewContent($viewName, $template)
    {
        $title = ucfirst(str_replace(['/', '_', '-'], ' ', $viewName));
        
        switch ($template) {
            case 'basic':
                return $this->getBasicTemplate($title);
            case 'form':
                return $this->getFormTemplate($title);
            case 'table':
                return $this->getTableTemplate($title);
            case 'empty':
                return $this->getEmptyTemplate($title);
            default:
                return $this->getBasicTemplate($title);
        }
    }
    
    private function getBasicTemplate($title)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title} - Brickpage</title>
    <link rel="stylesheet" href="/app/assets/css/app.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <div class="container px-4 py-8 mx-auto">
            <div class="max-w-4xl mx-auto">
                <h1 class="mb-6 text-3xl font-bold text-gray-900">{$title}</h1>
                
                <div class="p-6 bg-white rounded-lg shadow">
                    <p class="text-gray-600">
                        Willkommen auf der {$title} Seite. Diese View wurde automatisch erstellt.
                    </p>
                    
                    <div class="mt-6">
                        <a href="/" class="inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            ← Zurück zur Startseite
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }
    
    private function getFormTemplate($title)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title} - Brickpage</title>
    <link rel="stylesheet" href="/app/assets/css/app.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <div class="container px-4 py-8 mx-auto">
            <div class="max-w-2xl mx-auto">
                <h1 class="mb-6 text-3xl font-bold text-gray-900">{$title}</h1>
                
                <div class="p-6 bg-white rounded-lg shadow">
                    <form method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-Mail</label>
                            <input type="email" id="email" name="email" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Nachricht</label>
                            <textarea id="message" name="message" rows="4" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div class="flex space-x-4">
                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Absenden
                            </button>
                            <a href="/" class="px-4 py-2 text-gray-700 bg-gray-300 rounded-md hover:bg-gray-400">
                                Abbrechen
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }
    
    private function getTableTemplate($title)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title} - Brickpage</title>
    <link rel="stylesheet" href="/app/assets/css/app.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <div class="container px-4 py-8 mx-auto">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">{$title}</h1>
                    <button class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Neu hinzufügen
                    </button>
                </div>
                
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Datum</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">1</td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">Beispiel Eintrag</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktiv</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">01.01.2024</td>
                                <td class="px-6 py-4 space-x-2 text-sm font-medium whitespace-nowrap">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Bearbeiten</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Löschen</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    <a href="/" class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-300 rounded-md hover:bg-gray-400">
                        ← Zurück zur Startseite
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }
    
    private function getEmptyTemplate($title)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title} - Brickpage</title>
    <link rel="stylesheet" href="/app/assets/css/app.css">
</head>
<body>
    <!-- {$title} View Content -->
    
</body>
</html>
HTML;
    }
    
    private function loadRoutes()
    {
        $routesFile = __DIR__ . '/../../app/config/routes.php';
        if (!file_exists($routesFile)) {
            return [];
        }
        
        return require $routesFile;
    }
    
    private function findRoutesForView($viewName, $routes)
    {
        $viewRoutes = [];
        
        foreach ($routes as $route) {
            // route: [method, uri, handler, middlewares?]
            if (count($route) < 3) continue;
            
            [$method, $uri, $handler] = $route;
            
            // Check if handler is a direct view handler
            if (strpos($handler, 'view.') === 0) {
                $routeViewName = substr($handler, 5); // Remove 'view.' prefix
                
                if ($routeViewName === $viewName) {
                    $viewRoutes[] = [
                        'method' => $method,
                        'uri' => $uri,
                        'handler' => $handler,
                        'middlewares' => isset($route[3]) ? $route[3] : []
                    ];
                }
            }
            // Check if handler is a controller method that might use this view
            else if (strpos($handler, '.') !== false) {
                [$controllerName, $methodName] = explode('.', $handler, 2);
                
                if ($this->controllerUsesView($controllerName, $methodName, $viewName)) {
                    $viewRoutes[] = [
                        'method' => $method,
                        'uri' => $uri,
                        'handler' => $handler,
                        'middlewares' => isset($route[3]) ? $route[3] : []
                    ];
                }
            }
        }
        
        return $viewRoutes;
    }

    /**
     * Checks if a controller method uses a specific view
     */
    private function controllerUsesView($controllerName, $methodName, $viewName)
    {
        // Build controller file path
        $controllerPath = __DIR__ . '/' . $controllerName . '.php';
        
        if (!file_exists($controllerPath)) {
            return false;
        }
        
        // Read controller file content
        $content = file_get_contents($controllerPath);
        if ($content === false) {
            return false;
        }
        
        // Extract the method content
        $methodContent = $this->extractMethodContent($content, $methodName);
        if ($methodContent === null) {
            return false;
        }
        
        // Check if the method uses the view
        return $this->methodUsesView($methodContent, $viewName);
    }

    /**
     * Extracts the content of a specific method from controller source code
     */
    private function extractMethodContent($content, $methodName)
    {
        // Pattern to find the method
        $pattern = '/public\s+function\s+' . preg_quote($methodName) . '\s*\([^)]*\)\s*:\s*\w+\s*\{/';
        
        if (!preg_match($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
            return null;
        }
        
        $startPos = $matches[0][1] + strlen($matches[0][0]);
        $braceCount = 1;
        $pos = $startPos;
        $length = strlen($content);
        
        // Find the end of the method by counting braces
        while ($pos < $length && $braceCount > 0) {
            $char = $content[$pos];
            if ($char === '{') {
                $braceCount++;
            } elseif ($char === '}') {
                $braceCount--;
            }
            $pos++;
        }
        
        if ($braceCount === 0) {
            return substr($content, $startPos, $pos - $startPos - 1);
        }
        
        return null;
    }

    /**
     * Checks if method content uses a specific view
     */
    private function methodUsesView($methodContent, $viewName)
    {
        // Normalize view name (remove .php extension if present)
        $normalizedViewName = str_replace('.php', '', $viewName);
        
        // Common patterns for view usage in controllers:
        $patterns = [
            // require_once VIEW_DIR . '/auth/login.php';
            '/require_once\s+VIEW_DIR\s*\.\s*[\'"]\/?' . preg_quote($normalizedViewName, '/') . '\.php[\'"]/',
            // require VIEW_DIR . '/auth/login.php';
            '/require\s+VIEW_DIR\s*\.\s*[\'"]\/?' . preg_quote($normalizedViewName, '/') . '\.php[\'"]/',
            // include_once VIEW_DIR . '/auth/login.php';
            '/include_once\s+VIEW_DIR\s*\.\s*[\'"]\/?' . preg_quote($normalizedViewName, '/') . '\.php[\'"]/',
            // include VIEW_DIR . '/auth/login.php';
            '/include\s+VIEW_DIR\s*\.\s*[\'"]\/?' . preg_quote($normalizedViewName, '/') . '\.php[\'"]/',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $methodContent)) {
                return true;
            }
        }
        
        return false;
    }
}