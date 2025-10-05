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
  ['GET', '/login', 'LoginController.showLogin'],
  ['POST', '/login', 'LoginController.authenticate'],
  ['GET', '/logout', 'LoginController.logout'],
  ['GET', '/debug/users', 'LoginController.listUsers'],
  ['GET', '/dashboard', 'view.admin/dashboard', ['auth']],
  ['GET', '/admin/media', 'view.admin/media', ['auth']],
  ['GET', '/admin/pages', 'view.admin/pages', ['auth']],
  ['GET', '/admin/analytics', 'view.admin/analytics', ['auth']],
  ['GET', '/admin/collections', 'view.admin/collections', ['auth']],
  ['GET', '/admin/data', 'view.admin/data', ['auth']],
  ['GET', '/admin/bricks', 'view.admin/bricks', ['auth']],
  ['GET', '/settings', 'SettingsController.show', ['auth']],
  ['POST', '/settings/update', 'SettingsController.update', ['auth']],

  # ['GET', '/admin', 'view.admin/dashboard', ['auth']],
  ['GET', '/about', 'AboutController.show'],
  ['GET', '/test-view-manager', 'ViewManagerController.test'],
  ['POST', '/api/views/create', 'ViewManagerController.createView', ['auth']],
  ['GET', '/api/views/list', 'ViewManagerController.listViews', ['auth']],
  ['DELETE', '/api/views/delete', 'ViewManagerController.deleteView', ['auth']],
  ['GET', '/editor', 'EditorController.renderView', ['auth']],
  ['GET', '/editor/view/{viewName}', 'EditorController.view', ['auth']],
  ['POST', '/editor/save/{viewName}', 'EditorController.save', ['auth']],
  ['POST', '/editor/preview/{viewName}', 'EditorController.preview', ['auth']],
];