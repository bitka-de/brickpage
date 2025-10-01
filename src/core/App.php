<?php

declare(strict_types=1);

namespace Brick\Core;

class App
{
  private Router $router;

  public function __construct()
  {
    $this->router = new Router(routes: $this->loadRoutes());
  }

  private function loadRoutes(): array
  {
    return require CONFIG_DIR . '/routes.php';
  }

  public function run(): void
  {
    $this->router->dispatch();
  }
}
