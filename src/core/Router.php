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

            // Check if method matches and if URI matches (including parameters)
            if ($this->method === $method) {
                $routeParams = $this->matchRouteWithParams($uri, $this->normalizeUri($this->uri));
                
                if ($routeParams !== false) {
                    // Route matched, execute middlewares and handler
                    
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

                    // Controller mit Brick\Controller Namespace
                    $controllerClass = "Brick\\Controller\\{$controller}";
                    
                    if (class_exists($controllerClass) && method_exists($controllerClass, $action)) {
                        $controller = new $controllerClass();
                        
                        // If route has parameters, pass them to the controller method
                        if (!empty($routeParams)) {
                            $reflection = new \ReflectionMethod($controllerClass, $action);
                            $parameters = $reflection->getParameters();
                            
                            $args = [];
                            foreach ($parameters as $param) {
                                $paramName = $param->getName();
                                if (isset($routeParams[$paramName])) {
                                    $args[] = $routeParams[$paramName];
                                } elseif (!$param->isOptional()) {
                                    echo "Missing required parameter: {$paramName}";
                                    return;
                                }
                            }
                            
                            $controller->$action(...$args);
                        } else {
                            $controller->$action();
                        }
                        return;
                    }

                    # Eventuell später weitere Namensräume unterstützen
                    # z. B. "Api\UserController" -> "Brick\Controller\Api\UserController"

                    echo "Controller: {$controllerClass} not found";
                    return;
                }
            }
        }

        $this->handle404();
    }

    private function handle404(): void
    {
        http_response_code(404);
        echo '404 Not Found';
    }

    /**
     * Matches a route pattern with parameters against the actual URI
     * Returns false if no match, or array of parameters if match
     */
    private function matchRouteWithParams(string $routePattern, string $actualUri): array|false
    {
        // Normalize both URIs
        $routePattern = $this->normalizeUri($routePattern);
        $actualUri = $this->normalizeUri($actualUri);
        
        // If no parameters in route pattern, do exact match
        if (strpos($routePattern, '{') === false) {
            return $routePattern === $actualUri ? [] : false;
        }
        
        // Convert route pattern to regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePattern);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';
        
        if (!preg_match($pattern, $actualUri, $matches)) {
            return false;
        }
        
        // Extract parameter names from route pattern
        preg_match_all('/\{([^}]+)\}/', $routePattern, $paramNames);
        
        $params = [];
        for ($i = 1; $i < count($matches); $i++) {
            $paramName = $paramNames[1][$i - 1];
            $params[$paramName] = $matches[$i];
        }
        
        return $params;
    }

    private function normalizeUri(string $uri): string
    {
        // Kleine Robustheit: Query-String entfernen, trailing slash normalisieren
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        return rtrim($path, '/') ?: '/';
    }
}
