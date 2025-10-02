<?php

declare(strict_types=1);

namespace Brick\Core;

use Brick\Middleware\HelloMiddleware;
use Brick\Middleware\AuthMiddleware;

class MiddlewareRegistry
{
    /**
     * @var array<string, class-string<Middleware>>
     */
    private static array $middlewares = [
        'auth' => AuthMiddleware::class,
        'hello' => HelloMiddleware::class,
    ];

    /**
     * @param string $alias
     * @return class-string<Middleware>|null
     */
    public static function get(string $alias): ?string
    {
        return self::$middlewares[$alias] ?? null;
    }

    /**
     * @param string $alias
     * @param class-string<Middleware> $middlewareClass
     */
    public static function register(string $alias, string $middlewareClass): void
    {
        self::$middlewares[$alias] = $middlewareClass;
    }

    /**
     * @return array<string, class-string<Middleware>>
     */
    public static function all(): array
    {
        return self::$middlewares;
    }
}