<?php

declare(strict_types=1);

namespace Brick\Core;

class Router
{
    private string $method;
    private string $uri;
    /**
     * @var array<int, array{0:string,1:string,2:string,3?:array<int, class-string<Middleware>>}>
     * Struktur: [method, uri, handler, middlewares?]
     */
    private array $routes = [];
    private View $view;

    public function __construct(?string $method = null, ?string $uri = null, ?array $routes = null)
    {
        $this->method = $method ?: ($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->uri    = $uri    ?: ($_SERVER['REQUEST_URI']    ?? '/');
        $this->routes = $routes ?: []; // z. B. ['GET', '/hello', 'view.home', [HelloMiddleware::class]]
        $this->view   = new View();
    }

    public function dispatch(): void
    {
        $methodSeparator = '.'; // Trenner zwischen Controller und Methode bzw. View und Template

        foreach ($this->routes as $route) {
            // route: [method, uri, handler, middlewares?]
            [$method, $uri, $handler, $middlewares] = array_pad($route, 4, []);

            if ($this->method === $method && $this->normalizeUri($this->uri) === $this->normalizeUri($uri)) {

                // 1) Route-spezifische Middlewares ausführen
                foreach ($middlewares as $middlewareIdentifier) {
                    // Unterstützung für String-Aliases und Klassen-Namen
                    $middlewareClass = $middlewareIdentifier;
                    
                    // Wenn es ein String ist, versuche Alias-Auflösung
                    if (is_string($middlewareIdentifier) && !class_exists($middlewareIdentifier)) {
                        $middlewareClass = MiddlewareRegistry::get($middlewareIdentifier);
                        
                        if ($middlewareClass === null) {
                            echo "Middleware alias not found: {$middlewareIdentifier}";
                            return;
                        }
                    }

                    if (!class_exists($middlewareClass)) {
                        echo "Middleware class not found: {$middlewareClass}";
                        return;
                    }

                    $middleware = new $middlewareClass();

                    if (!($middleware instanceof Middleware)) {
                        echo "Middleware must implement " . Middleware::class;
                        return;
                    }

                    $result = $middleware->handle($this->method, $this->uri);

                    if ($result !== null) {
                        echo $result; // Middleware stoppt den Flow
                        return;
                    }
                }

                // 2) Handler ausführen (Controller oder View)
                [$controller, $action] = explode($methodSeparator, $handler);

                if ($controller === 'view') {
                    $this->view->render($action);
                    return;
                }

                if (class_exists($controller) && method_exists($controller, $action)) {
                    (new $controller())->$action();
                    return;
                }

                echo "Controller: {$controller} not found";
                return;
            }
        }

        $this->handle404();
    }

    private function handle404(): void
    {
        http_response_code(404);
        echo '404 Not Found';
    }

    private function normalizeUri(string $uri): string
    {
        // Kleine Robustheit: Query-String entfernen, trailing slash normalisieren
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        return rtrim($path, '/') ?: '/';
    }
}
