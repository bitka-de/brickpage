<?php

declare(strict_types=1);

/**
 * Definieren der Routen der Anwendung.
 * Jede Route ist ein Array mit:
 * - HTTP-Methode (z.B. 'GET', 'POST')
 * - URI-Pfad (z.B. '/', '/about')
 * - Handler (z.B. 'HomeController.index' oder 'view.home')
 * - Optionale Liste von Middlewares (z.B. ['auth', 'logging'])
 */

return [
  ['GET', '/', 'view.home'],
  ['GET', '/hello', 'view.home', ['hello']], 
  ['GET', '/admin', 'view.home', ['auth', 'hello']], // Mehrere Middlewares über String-Aliases
  ['GET', '/about', 'AboutController.show'],
];


