<?php
// Aktuelle Route ermitteln
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$currentPath = parse_url($currentPath, PHP_URL_PATH);

// Navigation Items definieren
$navItems = [
  'dashboard' => [
    'label' => 'Dashboard',
    'url' => '/dashboard',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>',
    'badge' => null
  ],
  'pages' => [
    'label' => 'Seiten',
    'url' => '/admin/pages',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>',
    'badge' => '6'
  ],
  'media' => [
    'label' => 'Medien',
    'url' => '/admin/media',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>',
    'badge' => null
  ],
  'analytics' => [
    'label' => 'Statistiken',
    'url' => '/admin/analytics',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/></svg>',
    'badge' => null
  ],
  'collections' => [
    'label' => 'Sammlungen',
    'url' => '/admin/collections',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>',
    'badge' => null
  ],
  'data' => [
    'label' => 'Daten',
    'url' => '/admin/data',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/></svg>',
    'badge' => null
  ],
  'bricks' => [
    'label' => 'Bricks',
    'url' => '/admin/bricks',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m21.12 6.4-6.05-4.06a2 2 0 0 0-2.17-.05L2.95 8.41a2 2 0 0 0-.95 1.7v5.82a2 2 0 0 0 .88 1.66l6.05 4.07a2 2 0 0 0 2.17.05l9.95-6.12a2 2 0 0 0 .95-1.7V8.06a2 2 0 0 0-.88-1.66"/><path d="M10 22v-8L2.25 9.15M10 14l11.77-6.87"/></svg>',
    'badge' => 'Beta'
  ]
];

// Prüfen ob aktueller Pfad aktiv ist
function isActive($url, $currentPath)
{
  return $currentPath === $url || str_starts_with($currentPath, $url . '/');
}
?>

<nav class="relative flex flex-col h-full w-72">
  <!-- Glassmorphism Background -->
  <div class="absolute inset-0 border-r backdrop-blur-xl border-white/10"></div>

  <!-- Animated Background Elements -->
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute w-24 h-24 rounded-full -top-4 -left-4 bg-blue-500/20 blur-xl animate-pulse"></div>
    <div class="absolute w-32 h-32 delay-1000 rounded-full top-1/3 -right-4 bg-purple-500/20 blur-xl animate-pulse"></div>
    <div class="absolute w-20 h-20 rounded-full bottom-1/4 left-1/4 bg-cyan-500/20 blur-xl animate-pulse delay-2000"></div>
  </div>


  <?php

  $admin_link = [
    'normal' => 'group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl hover:transition-transform hover:duration-300 hover:scale-[1.02]',
    'active' => 'absolute inset-0 border bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-cyan-500/20 rounded-xl backdrop-blur-sm border-white/20'
  ];
  ?>

  <!-- Content -->
  <div class="relative z-10 flex flex-col h-full">

    <!-- Navigation Links -->
    <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto scrollbar-hide">
      <?php foreach ($navItems as $key => $item): ?>
        <?php $active = isActive($item['url'], $currentPath); ?>
        <a href="<?= htmlspecialchars($item['url']) ?>"
          class="<?= $admin_link['normal']; ?>">

          <!-- Active State Background -->
          <?php if ($active): ?>
            <div class="<?= $admin_link['active']; ?>"></div>
            <div class="absolute inset-0 bg-white/5 rounded-xl"></div>
          <?php endif; ?>

          <!-- Hover State Background -->
          <div class="absolute inset-0 transition-opacity duration-300 opacity-0 bg-gradient-to-r from-white/5 via-white/10 to-white/5 rounded-xl group-hover:opacity-100"></div>

          <!-- Icon -->
          <span class="relative z-10 <?= $active ? 'text-blue-300' : 'text-white/70 group-hover:text-white' ?> mr-4 flex-shrink-0 transition-colors duration-300">
            <?= $item['icon'] ?>
          </span>

          <!-- Label -->
          <span class="relative z-10 flex-1 <?= $active ? 'text-white font-semibold' : 'text-white/80 group-hover:text-white' ?> transition-all duration-300">
            <?= htmlspecialchars($item['label']) ?>
          </span>

          <!-- Badge -->
          <?php if ($item['badge']): ?>
            <span class="relative z-10 ml-3 inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold rounded-full <?= is_numeric($item['badge']) ? 'bg-white/20 border border-white/30' : 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg' ?>">
              <?= htmlspecialchars($item['badge']) ?>
            </span>
          <?php endif; ?>

          <!-- Active Indicator -->
          <?php if ($active): ?>
            <div class="absolute right-0 w-1 h-8 -translate-y-1/2 rounded-l-full shadow-lg top-1/2 bg-gradient-to-b from-blue-400 via-purple-500 to-cyan-400"></div>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Floating Quick Actions -->
    <div class="px-4 py-4">
      <div class="relative">
        <div class="absolute inset-0 border bg-gradient-to-r from-white/10 via-white/5 to-white/10 rounded-2xl backdrop-blur-sm border-white/20"></div>
        <div class="relative p-4">
          <div class="mb-2">
            <span class="text-xs font-bold tracking-wider uppercase text-white/80">Aktueller Tarif</span>
          </div>

          <div class="flex items-center justify-between space-x-4">
            <div>
              <div class="text-sm font-semibold text-white">Basic</div>
              <div class="text-xs text-white/60">Grundtarif — alle Basisfunktionen</div>
            </div>

            <div>
              <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-white rounded-full shadow-lg bg-gradient-to-r from-blue-500 to-purple-500">
                Basic
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Settings & Footer -->
    <div class="px-4 pb-4 space-y-3">
      <!-- Settings Link -->
      <?php $settingsActive = isActive('/settings', $currentPath); ?>
      <a href="/settings"
        class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02]">

        <?php if ($settingsActive): ?>
          <div class="absolute inset-0 border bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-cyan-500/20 rounded-xl backdrop-blur-sm border-white/20"></div>
          <div class="absolute inset-0 bg-white/5 rounded-xl"></div>
        <?php endif; ?>

        <div class="absolute inset-0 transition-opacity duration-300 opacity-0 bg-gradient-to-r from-white/5 via-white/10 to-white/5 rounded-xl group-hover:opacity-100"></div>

        <span class="relative z-10 <?= $settingsActive ? 'text-blue-300' : 'text-white/70 group-hover:text-white' ?> mr-4 flex-shrink-0 transition-colors duration-300">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </span>
        <span class="relative z-10 <?= $settingsActive ? 'text-white font-semibold' : 'text-white/80 group-hover:text-white' ?> transition-all duration-300">
          Einstellungen
        </span>

        <?php if ($settingsActive): ?>
          <div class="absolute right-0 w-1 h-8 -translate-y-1/2 rounded-l-full shadow-lg top-1/2 bg-gradient-to-b from-blue-400 via-purple-500 to-cyan-400"></div>
        <?php endif; ?>
      </a>

      <!-- Footer Info -->
      <div class="relative">
        <div class="absolute inset-0 border bg-white/5 rounded-xl backdrop-blur-sm border-white/10"></div>
        <div class="relative px-4 py-3">
          <div class="flex items-center justify-between text-xs">
            <span class="font-medium text-white/60">Version 1.0.0</span>
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 rounded-full shadow-lg bg-gradient-to-r from-green-400 to-emerald-400 animate-pulse shadow-green-400/50"></div>
              <span class="font-semibold text-green-300">Online</span>
            </div>
          </div>
          <div class="h-1 mt-2 overflow-hidden rounded-full bg-white/10">
            <div class="h-full bg-gradient-to-r from-blue-400 via-purple-500 to-cyan-400 animate-pulse"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<style>
  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
</style>

<script>
  // Logout function
  function logout() {
    if (confirm('Möchten Sie sich wirklich abmelden?')) {
      window.location.href = '/logout';
    }
  }

  // Simple navigation interactions
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-save scroll position
    const navContainer = document.querySelector('.overflow-y-auto');
    if (navContainer) {
      const savedScrollPos = localStorage.getItem('nav-scroll-position');
      if (savedScrollPos) {
        navContainer.scrollTop = parseInt(savedScrollPos);
      }

      navContainer.addEventListener('scroll', () => {
        localStorage.setItem('nav-scroll-position', navContainer.scrollTop);
      });
    }
  });
</script>
</script>