<?php

declare(strict_types=1);

namespace Brick\Core;

class Router
{
  private string $method;
  private string $uri;
  private array $routes = [];
  private View $view;

  public function __construct(?string $method = null, ?string $uri = null, ?array $routes = null)
  {
    $this->method = $method ?: $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $this->uri = $uri ?:  $_SERVER['REQUEST_URI'] ?? '/';
    $this->routes = $routes ?: []; # eg. [method, uri, handler]
    $this->view = new View();
  }

  public function dispatch(): void
  {
    $methodSeparator = '.';

    foreach ($this->routes as [$method, $uri, $handler]) {

      if ($this->method === $method && $this->uri === $uri) {

        [$controller, $action] = explode($methodSeparator, $handler);
        if (class_exists($controller) && method_exists($controller, $action)) {

          (new $controller())->$action();
          return;
        } else {

          if ($controller === 'view') {
        
            $this->view->render($action);
            return;
          } 

          echo "Controller: $controller not found";
          return;
        }
      }
    }

    $this->handle404();
  }

  private function handle404(): void
  {
    http_response_code(404);
    echo "404 Not Found";
  }
}
