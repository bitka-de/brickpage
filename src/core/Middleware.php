<?php

declare(strict_types=1);

namespace Brick\Core;

interface Middleware
{
    /**
     * Wird vor dem Handler ausgeführt.
     * Gibt ein String-Ergebnis zurück, um den Flow zu stoppen (z. B. "Hello Middleware"),
     * oder null, um zum nächsten Schritt (nächste Middleware/Handler) weiterzugehen.
     */
    public function handle(string $method, string $uri): ?string;
}
