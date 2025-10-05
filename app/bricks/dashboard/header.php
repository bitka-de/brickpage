<header class="z-20 mx-auto admin-layout__header">
  <!-- Logo/Header -->
  <div class="flex items-center justify-center h-20 px-6 border-b border-white/10">
    <div class="flex items-center space-x-3">
      <div class="relative">
        <div class="absolute inset-0 opacity-75 bg-gradient-to-br from-blue-400 via-purple-500 to-cyan-400 rounded-xl blur-md animate-pulse"></div>
        <div class="relative flex items-center justify-center w-10 h-10 shadow-lg bg-gradient-to-br from-blue-500 via-purple-600 to-cyan-500 rounded-xl">
          <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
          </svg>
        </div>
      </div>
      <div>
        <span class="text-xl font-bold text-transparent bg-gradient-to-r from-white via-blue-100 to-cyan-100 bg-clip-text">
          Brickpage
        </span>
        <div class="text-xs font-medium text-white/60">Admin Studio</div>
      </div>
    </div>
  </div>

  <div class="flex items-center gap-3 ml-auto">
    <!-- quick actions -->
    <button id="btn-search" class="p-2 rounded-lg bg-white/5 hover:bg-white/8 text-white/70" aria-label="Search (Ctrl/⌘+K)">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
      </svg>
    </button>

    <button id="btn-notifications" class="relative p-2 rounded-lg bg-white/5 hover:bg-white/8 text-white/70" aria-label="Notifications" aria-expanded="false">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM8 17a2 2 0 104 0H8z"/>
      </svg>
      <span id="notif-badge" class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold text-white bg-rose-500 rounded-full">3</span>
    </button>

    <!-- notifications popover -->
    <div id="notifications-popover" class="absolute right-0 z-50 hidden mt-2 overflow-hidden border rounded-lg shadow-lg w-72 bg-slate-800 border-white/6">
      <div class="p-3 text-sm font-semibold text-white">Notifications</div>
      <ul id="notif-list" class="overflow-auto text-sm divide-y divide-white/3 max-h-48 text-white/80">
        <li class="p-3">New comment on "Homepage" · <span class="text-xs text-slate-400">2h ago</span></li>
        <li class="p-3">Build passed · <span class="text-xs text-slate-400">4h ago</span></li>
        <li class="p-3">New user signup · <span class="text-xs text-slate-400">1d ago</span></li>
      </ul>
      <div class="flex items-center justify-between p-2 border-t border-white/6">
        <button id="clear-notifs" class="px-3 py-1 text-xs rounded bg-white/5 hover:bg-white/8">Clear all</button>
        <button id="view-all-notifs" class="px-3 py-1 text-xs rounded bg-white/5 hover:bg-white/8">View all</button>
      </div>
    </div>

    <!-- user card -->
    <div class="relative flex items-center gap-3 p-2 pr-3 border shadow-sm rounded-xl bg-white/5 border-white/6 backdrop-blur-sm" id="user-card">
      <div class="min-w-0 leading-tight text-right">
        <div class="text-sm font-semibold text-white truncate"><?= htmlspecialchars($userName) ?></div>
        <div class="text-xs truncate text-slate-400"><?= htmlspecialchars($userEmail) ?></div>
      </div>

      <div class="relative">
        <img src="https://randomuser.me/api/portraits/men/99.jpg" alt="Profilbild" class="object-cover w-10 h-10 rounded-full ring-2 ring-white/10" />
        <span class="absolute bottom-0 right-0 block w-3 h-3 bg-green-400 rounded-full ring-2 ring-white animate-pulse" title="online"></span>
      </div>

      <button id="btn-user-menu" class="p-2 rounded-md text-white/70 hover:bg-white/8" aria-haspopup="true" aria-expanded="false" aria-label="Open user menu">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>

      <!-- user menu -->
      <div id="user-menu" class="absolute right-0 z-50 hidden w-48 mt-3 border rounded-lg shadow-lg top-full bg-slate-800 border-white/6">
        <a href="/profile" class="block px-4 py-2 text-sm text-white hover:bg-white/5">Profile</a>
        <a href="/settings" class="block px-4 py-2 text-sm text-white hover:bg-white/5">Settings</a>
        <div class="border-t border-white/6"></div>
        <form method="POST" action="/logout" class="m-0">
          <button type="submit" class="w-full px-4 py-2 text-sm text-left text-white hover:bg-white/5">Sign out</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Search overlay (modal) -->
  <div id="search-overlay" class="fixed inset-0 z-50 flex items-start justify-center hidden px-4 pt-24">
    <div class="absolute inset-0 bg-black/60" data-close-search></div>
    <div class="relative w-full max-w-2xl p-4 border shadow-xl bg-slate-900 border-white/6 rounded-xl">
      <div class="flex items-center gap-3">
        <input id="search-input" class="flex-1 text-sm text-white bg-transparent focus:outline-none placeholder:text-slate-400" type="search" placeholder="Search... (Enter to search)" />
        <button id="close-search" class="p-2 rounded-md text-white/70 hover:bg-white/8" aria-label="Close search">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div id="search-suggestions" class="hidden mt-3 text-sm text-slate-400">
        Press Enter to perform a quick search. Try "dashboard", "pages", or "users".
      </div>
    </div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const btnSearch = document.getElementById('btn-search');
    const searchOverlay = document.getElementById('search-overlay');
    const closeSearch = document.getElementById('close-search');
    const searchInput = document.getElementById('search-input');
    const suggestions = document.getElementById('search-suggestions');

    const btnNotifs = document.getElementById('btn-notifications');
    const notifPopover = document.getElementById('notifications-popover');
    const notifBadge = document.getElementById('notif-badge');
    const clearNotifs = document.getElementById('clear-notifs');

    const btnUser = document.getElementById('btn-user-menu');
    const userMenu = document.getElementById('user-menu');
    const userCard = document.getElementById('user-card');

    // Helpers
    function toggle(el, show) {
      if (!el) return;
      const isHidden = el.classList.contains('hidden');
      if (show === undefined) show = isHidden;
      el.classList.toggle('hidden', !show);
    }

    function setExpanded(button, el, expanded) {
      if (button) button.setAttribute('aria-expanded', String(expanded));
      if (el) el.classList.toggle('hidden', !expanded);
    }

    function closeAllPopovers() {
      if (notifPopover) notifPopover.classList.add('hidden');
      if (userMenu) userMenu.classList.add('hidden');
      if (btnNotifs) btnNotifs.setAttribute('aria-expanded', 'false');
      if (btnUser) btnUser.setAttribute('aria-expanded', 'false');
    }

    // Search open/close
    if (btnSearch && searchOverlay && searchInput) {
      btnSearch.addEventListener('click', () => {
        setExpanded(null, searchOverlay, true);
        searchOverlay.classList.remove('hidden');
        searchInput.focus();
        suggestions && suggestions.classList.remove('hidden');
      });
    }
    if (closeSearch && searchOverlay) {
      closeSearch.addEventListener('click', () => {
        searchOverlay.classList.add('hidden');
        suggestions && suggestions.classList.add('hidden');
      });
    }
    document.querySelectorAll('[data-close-search]').forEach(el => el.addEventListener('click', () => {
      searchOverlay && searchOverlay.classList.add('hidden');
      suggestions && suggestions.classList.add('hidden');
    }));

    // Keyboard shortcuts: Ctrl/Cmd+K to open, Esc to close
    document.addEventListener('keydown', (e) => {
      const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        if (searchOverlay && searchInput) {
          searchOverlay.classList.remove('hidden');
          searchInput.focus();
          suggestions && suggestions.classList.remove('hidden');
        }
      } else if (e.key === 'Escape') {
        if (searchOverlay && !searchOverlay.classList.contains('hidden')) {
          searchOverlay.classList.add('hidden');
          suggestions && suggestions.classList.add('hidden');
        }
        closeAllPopovers();
      }
    });

    // Search submit (demo)
    if (searchInput) {
      searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          const q = searchInput.value.trim();
          if (!q) return;
          console.log('Search:', q);
          searchOverlay.classList.add('hidden');
          suggestions && suggestions.classList.add('hidden');
        }
      });
    }

    // Notifications toggle & clear
    if (btnNotifs && notifPopover) {
      btnNotifs.addEventListener('click', (e) => {
        e.stopPropagation();
        toggle(notifPopover);
        const expanded = !notifPopover.classList.contains('hidden');
        btnNotifs.setAttribute('aria-expanded', String(expanded));
        // close user menu when opening notifications
        if (userMenu && !userMenu.classList.contains('hidden')) {
          userMenu.classList.add('hidden');
          btnUser && btnUser.setAttribute('aria-expanded', 'false');
        }
      });
    }
    if (clearNotifs) {
      clearNotifs.addEventListener('click', () => {
        const list = document.getElementById('notif-list');
        if (list) list.innerHTML = '<li class="p-3 text-slate-400">No notifications</li>';
        notifBadge && notifBadge.classList.add('hidden');
      });
    }

    // User menu toggle
    if (btnUser && userMenu) {
      btnUser.addEventListener('click', (e) => {
        e.stopPropagation();
        toggle(userMenu);
        const expanded = !userMenu.classList.contains('hidden');
        btnUser.setAttribute('aria-expanded', String(expanded));
        // close notifications when opening user menu
        if (notifPopover && !notifPopover.classList.contains('hidden')) {
          notifPopover.classList.add('hidden');
          btnNotifs && btnNotifs.setAttribute('aria-expanded', 'false');
        }
      });
    }

    // Close popovers on outside click
    document.addEventListener('click', (e) => {
      const target = e.target;
      const insideNotif = notifPopover && (notifPopover.contains(target) || (btnNotifs && btnNotifs.contains(target)));
      const insideUser = userMenu && (userMenu.contains(target) || (userCard && userCard.contains(target)));
      const insideSearch = searchOverlay && !searchOverlay.classList.contains('hidden') && searchOverlay.contains(target);

      if (!insideNotif && notifPopover) {
        notifPopover.classList.add('hidden');
        btnNotifs && btnNotifs.setAttribute('aria-expanded', 'false');
      }
      if (!insideUser && userMenu) {
        userMenu.classList.add('hidden');
        btnUser && btnUser.setAttribute('aria-expanded', 'false');
      }
      // search overlay background handler is data-close-search
    });
  });
  </script>
</header>