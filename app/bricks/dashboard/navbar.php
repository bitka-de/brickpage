  <!-- Navigation -->
  <nav class="border-b border-white shadow-sm bg-gradient-to-bl from-white">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="flex items-center flex-shrink-0">
            <a href="/<?= ADMIN_DASHBOARD ?>" class="flex items-center transition-opacity duration-200 hover:opacity-80">
              <img src="/img/logo.png" alt="Logo <?= _get('app.name') ?>" class="h-9">
            </a>
          </div>

          <!-- Navigation Links -->
          <!--
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-[#ffcc00]">
              Mash
            </a>
            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
              Users
            </a>
            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
              Settings
            </a>
          </div>
          -->
        </div>

        <!-- User Menu -->
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <!-- Profile dropdown -->
          <div class="relative ml-3">
            <div class="flex items-center space-x-3">

              <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($userName) ?></span>
                <?php if ($userEmail): ?>
                  <span class="text-xs text-gray-500"><?= htmlspecialchars($userEmail) ?></span>
                <?php endif; ?>
              </div>

              <img class="w-10 h-10 rounded-md" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Profile">


            </div>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="flex items-center -mr-2 sm:hidden">
          <button
            class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
            data-mobile-menu-toggle
            aria-expanded="false"
            aria-controls="mobile-menu">
            <span class="sr-only">Open main menu</span>
            <svg class="block w-6 h-6" data-menu-open fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg class="hidden w-6 h-6" data-menu-close fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>

          
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state -->
    <div class="hidden sm:hidden" id="mobile-menu" data-mobile-menu>
      <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="#" class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md bg-gray-50">
          Dashboard
        </a>
        <a href="#" class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md hover:text-gray-700 hover:bg-gray-50">
          Users
        </a>
        <a href="#" class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md hover:text-gray-700 hover:bg-gray-50">
          Settings
        </a>
        <div class="pt-4 pb-3 border-t border-gray-200">
          <div class="flex items-center px-3">
            <div class="flex-shrink-0">
              <img class="w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800"><?= htmlspecialchars($userName) ?></div>
              <div class="text-sm font-medium text-gray-500"><?= htmlspecialchars($userEmail) ?></div>
            </div>
          </div>
          <div class="mt-3 space-y-1">
            <a href="/" target="_blank" class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md hover:text-gray-700 hover:bg-gray-50">
              Website öffnen
            </a>
            <a href="/logout" class="block px-3 py-2 text-base font-medium text-red-600 rounded-md hover:text-red-700 hover:bg-red-50">
              Logout
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>