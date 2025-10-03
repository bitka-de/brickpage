<?php

declare(strict_types=1);

/**
 * Konfiguration für Benutzerrollen und Berechtigungen.
 */

return [
  'roles' => [
    'admin' => [
      'permissions' => ['view.admin.dashboard', 'manage.users', 'view.reports'],
    ],
    'editor' => [
      'permissions' => ['view.editor.dashboard', 'edit.articles'],
    ],
    'viewer' => [
      'permissions' => ['view.viewer.dashboard'],
    ],
  ],

  'users' => [
    [
      'id' => 1,
      'name' => 'John Doe',
      'email' => 'admin@admin.de',
      'role' => 'admin',
      'status' => 'active',
      'created_at' => '2025-01-10 09:15:00',
      'password' => password_hash('Admin123!', PASSWORD_BCRYPT), // Admin123!
    ],
    [
      'id' => 2,
      'name' => 'Jane Smith',
      'email' => 'j.smith@example.com',
      'role' => 'editor',
      'status' => 'active',
      'created_at' => '2025-02-20 11:30:00',
      'password' => password_hash('Admin123!', PASSWORD_BCRYPT), // Admin123!
    ],
    [
      'id' => 3,
      'name' => 'Tom Jones',
      'email' => 't.jones@example.com',
      'role' => 'viewer',
      'status' => 'inactive',
      'created_at' => '2025-03-15 14:45:00',
      'password' => password_hash('Viewer!2025', PASSWORD_BCRYPT), // Viewer!2025
    ],
  ]
];
