<?php

declare(strict_types=1);

namespace Brick\Middleware;

use Brick\Core\Middleware;

class AuthMiddleware implements Middleware
{
    public function handle(string $method, string $uri): ?string
    {
        echo "🔐 AuthMiddleware: Benutzer authentifiziert!<br>";
        return null; // Flow geht weiter
    }
}