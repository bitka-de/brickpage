<?php

return [
  'site' => [
    'name' => 'Mein Startup 21',
    'tagline' => 'Code live, Build fast',
    'language' => 'de',
    'timezone' => 'Europe/Berlin',
    'domain' => 'www.meinstartup.de',
  ],
  'company' => [
    'name' => 'Mein Startup GmbH',
    'legal_form' => 'GmbH',
    'address' => 'Musterstraße 1, 12345 Musterstadt',
    'email' => 'info@meinstartup.de',
    'phone' => '+49 123 4567890',
    'tax_id' => 'DE123456789', // Umsatzsteuer‑Identifikationsnummer (USt‑IdNr.)
    'tax_number' => '123/456/789', // Steuernummer (falls vorhanden)
    'managing_directors' => [
      0 => 'Max Mustermann',
    ],
    'commercial_register' => [
      'court' => 'Amtsgericht Musterstadt',
      'number' => 'HRB 12345',
    ],
    'responsible_person' => 'Max Mustermann', // Verantwortlicher nach §55 Abs.2 RStV
  ],
  'theme' => [
    'template' => 'business',
    'palette' => [
      'primary' => '#1e88e5',
      'secondary' => '#f5a623',
    ],
    'font' => 'Inter',
    'layout' => 'standard',
  ],
  'navigation' => [
    0 => [
      'label' => 'Home',
      'path' => '/',
    ],
    1 => [
      'label' => 'Über uns',
      'path' => '/about',
    ],
    2 => [
      'label' => 'Leistungen',
      'path' => '/services',
    ],
    3 => [
      'label' => 'Blog',
      'path' => '/blog',
    ],
    4 => [
      'label' => 'Kontakt',
      'path' => '/contact',
    ],
    5 => [
      'label' => 'Elefant',
      'path' => '/elefant',
    ],
  ],
  'pages' => [
    0 => [
      'slug' => 'home',
      'title' => 'Willkommen',
      'components' => [
        0 => [
          'type' => 'hero',
          'data' => [
            'title' => 'Schnell starten — sofort live',
            'subtitle' => 'Wir bauen digitale Produkte, die funktionieren.',
            'cta' => [
              'text' => 'Kostenlos starten',
              'href' => '/signup',
            ],
          ],
        ],
        1 => [
          'type' => 'features',
          'data' => [
            0 => [
              'title' => 'Schnell',
              'desc' => 'MVP in Tagen',
            ],
            1 => [
              'title' => 'Skalierbar',
              'desc' => 'Wächst mit deinem Produkt',
            ],
            2 => [
              'title' => 'Teamfreundlich',
              'desc' => 'Designer & Developer arbeiten zusammen',
            ],
          ],
        ],
      ],
      'seo' => [
        'title' => 'Mein Startup — Build fast',
        'description' => 'Wir helfen Teams schneller zu bauen.',
      ],
    ],
  ],
  'integrations' => [
    'analytics' => [
      'provider' => 'ga',
      'tracking_id' => 'UA-XXXXX-Y',
    ],
    'mail' => [
      'provider' => 'mailchimp',
      'api_key' => 'xxx',
      'list_id' => 'yyy',
    ],
  ],
  'users' => [
    0 => [
      'email' => 'max@beispiel.de',
      'role' => 'admin',
    ],
  ],
  'publish' => [
    'auto_ssl' => true,
    'staging' => true,
  ],
];
