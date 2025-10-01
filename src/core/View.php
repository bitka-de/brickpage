<?php

declare(strict_types=1);

namespace Brick\Core;

class View
{
  public static function render(string $template, array $data = []): void
  {
    if (!file_exists(VIEW_DIR . '/' . $template . '.php')) {
      http_response_code(404);
      echo "404 Not Found";
      return;
    }

    extract($data);
    require VIEW_DIR . '/' . $template . '.php';
  }
}
