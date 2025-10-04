<?php

return [
  'site' => [
    'name'     => 'Mein Startup',
    'tagline'  => 'Code live, Build fast',
    'language' => 'de',
    'timezone' => 'Europe/Berlin',
    'domain'   => 'www.meinstartup.de',
  ],

  'theme' => [
    'template' => 'business',
    'palette'  => [
      'primary'   => '#1E88E5',
      'secondary' => '#F5A623',
    ],
    'font'   => 'Inter',
    'layout' => 'standard',
  ],

  'navigation' => [
    ['label' => 'Home',      'path' => '/'],
    ['label' => 'Über uns',  'path' => '/about'],
    ['label' => 'Leistungen','path' => '/services'],
    ['label' => 'Blog',      'path' => '/blog'],
    ['label' => 'Kontakt',   'path' => '/contact'],
  ],

  'pages' => [
    [
      'slug'       => 'home',
      'title'      => 'Willkommen',
      'components' => [
        [
          'type' => 'hero',
          'data' => [
            'title'    => 'Schnell starten — sofort live',
            'subtitle' => 'Wir bauen digitale Produkte, die funktionieren.',
            'cta'      => ['text' => 'Kostenlos starten', 'href' => '/signup'],
          ],
        ],
        [
          'type' => 'features',
          'data' => [
            ['title' => 'Schnell',         'desc' => 'MVP in Tagen'],
            ['title' => 'Skalierbar',      'desc' => 'Wächst mit deinem Produkt'],
            ['title' => 'Teamfreundlich',  'desc' => 'Designer & Developer arbeiten zusammen'],
          ],
        ],
      ],
      'seo' => [
        'title'       => 'Mein Startup — Build fast',
        'description' => 'Wir helfen Teams schneller zu bauen.',
      ],
    ],
  ],

  'integrations' => [
    'analytics' => ['provider' => 'ga',        'tracking_id' => 'UA-XXXXX-Y'],
    'mail'      => ['provider' => 'mailchimp', 'api_key'    => 'xxx', 'list_id' => 'yyy'],
  ],

  'users' => [
    ['email' => 'max@beispiel.de', 'role' => 'admin'],
  ],

  'publish' => [
    'auto_ssl' => true,
    'staging'  => true,
  ],
];