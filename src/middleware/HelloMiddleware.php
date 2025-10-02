<?php

declare(strict_types=1);

namespace Brick\Middleware;

use Brick\Core\Middleware;

class HelloMiddleware implements Middleware
{
    public function handle(string $method, string $uri): ?string
    {
        echo "🚀 HelloMiddleware hat zugeschlagen!<br>";
        return null; // null = Flow geht weiter, string = Flow wird gestoppt
    }
}
