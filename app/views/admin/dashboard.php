<?php
// Aktuellen Benutzer aus Session laden
use Brick\Controller\LoginController;

$loginController = new LoginController();
$currentUser = $loginController->getCurrentUser();
$userName = $currentUser ? $currentUser['name'] : 'Unbekannter Benutzer';
$userEmail = $currentUser ? $currentUser['email'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= _get('app.name') ?> - Admin Dashboard</title>
  <!-- Asset Loading: Automatisch Dev/Production -->
  <?= Brick\Core\AssetHelper::viteAssets() ?>
</head>

<body class="bg-gray-100">
  
  <!-- Navigation -->
  <nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="flex items-center flex-shrink-0">
            <a href="/<?= ADMIN_DASHBOARD ?>" class="flex items-center transition-opacity duration-200 hover:opacity-80">
              <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-lg">
                <span class="text-sm font-bold text-white"><?= substr(_get('app.name'), 0, 1) ?></span>
              </div>
              <span class="ml-2 text-xl font-semibold text-gray-900"><?= _get('app.name') ?></span>
            </a>
          </div>
          
          <!-- Navigation Links -->
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-blue-500">
              Dashboard
            </a>
            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
              Users
            </a>
            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
              Settings
            </a>
          </div>
        </div>
        
        <!-- User Menu -->
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <!-- Notifications -->
          <button class="p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <span class="sr-only">View notifications</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6l3 3-3 3h-6l-3-3 3-3z"></path>
            </svg>
          </button>

          <!-- Profile dropdown -->
          <div class="relative ml-3">
            <div class="flex items-center space-x-3">
              <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Profile">
              <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($userName) ?></span>
                <?php if ($userEmail): ?>
                  <span class="text-xs text-gray-500"><?= htmlspecialchars($userEmail) ?></span>
                <?php endif; ?>
              </div>
              
              <!-- Logout Button -->
              <a href="/logout" class="inline-flex items-center px-3 py-2 ml-3 text-sm font-medium leading-4 text-red-700 transition-colors duration-200 bg-red-100 border border-transparent rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class=" -ml-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                
              </a>
            </div>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="flex items-center -mr-2 sm:hidden">
          <button 
            class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
            data-mobile-menu-toggle
            aria-expanded="false"
            aria-controls="mobile-menu"
          >
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

  <!-- Main Content -->
  <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="px-4 py-6 sm:px-0">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
          <p class="mt-1 text-sm text-gray-500">Welcome back, <?= htmlspecialchars($userName) ?>! Here's what's happening.</p>
        </div>
        <div class="flex space-x-3">
          <a href="/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-700 border border-blue-200 rounded-md shadow-sm bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Website
          </a>
          <button class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Export
          </button>
          <button class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            New Item
          </button>
        </div>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="px-4 sm:px-0">
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Stat Card 1 -->
        <div class="overflow-hidden bg-white rounded-lg shadow">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-md">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="flex-1 w-0 ml-5">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                  <dd class="text-lg font-medium text-gray-900">1,247</dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="px-5 py-3 bg-gray-50">
            <div class="text-sm">
              <span class="font-medium text-green-600">+12%</span>
              <span class="text-gray-500">from last month</span>
            </div>
          </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="overflow-hidden bg-white rounded-lg shadow">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-md">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="flex-1 w-0 ml-5">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Revenue</dt>
                  <dd class="text-lg font-medium text-gray-900">$48,642</dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="px-5 py-3 bg-gray-50">
            <div class="text-sm">
              <span class="font-medium text-green-600">+8%</span>
              <span class="text-gray-500">from last month</span>
            </div>
          </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="overflow-hidden bg-white rounded-lg shadow">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-8 h-8 bg-yellow-500 rounded-md">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div>
              </div>
              <div class="flex-1 w-0 ml-5">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Page Views</dt>
                  <dd class="text-lg font-medium text-gray-900">89,421</dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="px-5 py-3 bg-gray-50">
            <div class="text-sm">
              <span class="font-medium text-red-600">-3%</span>
              <span class="text-gray-500">from last month</span>
            </div>
          </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="overflow-hidden bg-white rounded-lg shadow">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-8 h-8 bg-purple-500 rounded-md">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                </div>
              </div>
              <div class="flex-1 w-0 ml-5">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Conversion Rate</dt>
                  <dd class="text-lg font-medium text-gray-900">3.24%</dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="px-5 py-3 bg-gray-50">
            <div class="text-sm">
              <span class="font-medium text-green-600">+0.5%</span>
              <span class="text-gray-500">from last month</span>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Content Grid -->
    <div class="px-4 mt-8 sm:px-0">
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        
        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Recent Activity</h3>
            <div class="flow-root">
              <ul class="-mb-8">
                <li class="relative pb-8">
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1494790108755-2616b612b647?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                      <div>
                        <div class="text-sm">
                          <span class="font-medium text-gray-900">Leslie Alexander</span>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500">Created new account</p>
                      </div>
                      <div class="mt-2 text-sm text-gray-700">
                        <p>Welcome to the platform!</p>
                      </div>
                    </div>
                    <div class="self-start flex-shrink-0">
                      <span class="text-sm text-gray-500">2h ago</span>
                    </div>
                  </div>
                </li>
                
                <li class="relative pb-8">
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                      <div>
                        <div class="text-sm">
                          <span class="font-medium text-gray-900">Michael Foster</span>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500">Updated profile settings</p>
                      </div>
                      <div class="mt-2 text-sm text-gray-700">
                        <p>Profile information has been updated.</p>
                      </div>
                    </div>
                    <div class="self-start flex-shrink-0">
                      <span class="text-sm text-gray-500">4h ago</span>
                    </div>
                  </div>
                </li>

                <li class="relative">
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                      <div>
                        <div class="text-sm">
                          <span class="font-medium text-gray-900">Dries Vincent</span>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500">Made a purchase</p>
                      </div>
                      <div class="mt-2 text-sm text-gray-700">
                        <p>Purchased premium subscription.</p>
                      </div>
                    </div>
                    <div class="self-start flex-shrink-0">
                      <span class="text-sm text-gray-500">6h ago</span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="mt-6">
              <a href="#" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                View all activity
              </a>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
              
              <button class="relative p-6 rounded-lg group bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 hover:bg-gray-100">
                <div>
                  <span class="inline-flex p-3 text-blue-700 rounded-lg bg-blue-50 ring-4 ring-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                  </span>
                </div>
                <div class="mt-8">
                  <h3 class="text-lg font-medium">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    Add User
                  </h3>
                  <p class="mt-2 text-sm text-gray-500">Create a new user account</p>
                </div>
              </button>

              <button class="relative p-6 rounded-lg group bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 hover:bg-gray-100">
                <div>
                  <span class="inline-flex p-3 text-green-700 rounded-lg bg-green-50 ring-4 ring-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </span>
                </div>
                <div class="mt-8">
                  <h3 class="text-lg font-medium">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    Generate Report
                  </h3>
                  <p class="mt-2 text-sm text-gray-500">Create analytics report</p>
                </div>
              </button>

              <button class="relative p-6 rounded-lg group bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500 hover:bg-gray-100">
                <div>
                  <span class="inline-flex p-3 text-yellow-700 rounded-lg bg-yellow-50 ring-4 ring-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                  </span>
                </div>
                <div class="mt-8">
                  <h3 class="text-lg font-medium">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    Settings
                  </h3>
                  <p class="mt-2 text-sm text-gray-500">Manage system settings</p>
                </div>
              </button>

              <button class="relative p-6 rounded-lg group bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-purple-500 hover:bg-gray-100">
                <div>
                  <span class="inline-flex p-3 text-purple-700 rounded-lg bg-purple-50 ring-4 ring-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                  </span>
                </div>
                <div class="mt-8">
                  <h3 class="text-lg font-medium">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    Analytics
                  </h3>
                  <p class="mt-2 text-sm text-gray-500">View detailed analytics</p>
                </div>
              </button>

              <a href="/logout" class="relative p-6 border-2 border-red-200 border-dashed rounded-lg group bg-red-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-500 hover:bg-red-100">
                <div class="flex items-center justify-center">
                  <span class="inline-flex p-3 text-red-700 bg-red-100 rounded-lg ring-4 ring-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                  </span>
                </div>
                <div class="mt-4 text-center">
                  <h3 class="text-lg font-medium text-red-700">
                    Logout
                  </h3>
                </div>
              </a>

            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- System Status -->
    <?php if (_get('debug')): ?>
    <div class="px-4 mt-8 sm:px-0">
      <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">System Status</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            
            <div class="p-4 border border-green-200 rounded-lg bg-green-50">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-green-800">Framework</h3>
                  <div class="mt-2 text-sm text-green-700">
                    <p>Status: Online</p>
                    <p>Version: <?= _get('app.version') ?></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-blue-800">Environment</h3>
                  <div class="mt-2 text-sm text-blue-700">
                    <p>Mode: <?= _get('env') ?></p>
                    <p>Debug: <?= _get('debug') ? 'Enabled' : 'Disabled' ?></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-4 border border-yellow-200 rounded-lg bg-yellow-50">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-yellow-800">Assets</h3>
                  <div class="mt-2 text-sm text-yellow-700">
                    <p>Mode: <?= _get('dev_mode') ? 'Development' : 'Production' ?></p>
                    <p>Server: <?= _get('dev_mode') ? 'Vite' : 'Static' ?></p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div>

<script>
// Mobile Menu Toggle
class AdminDashboard {
  constructor(doc = document) {
    this.doc = doc;

    // Mobile menu
    this.mobileMenuButton = this.doc.querySelector('[data-mobile-menu-toggle]');
    this.mobileMenu = this.doc.querySelector('[data-mobile-menu]');
    this.menuOpenIcon = this.doc.querySelector('[data-menu-open]');
    this.menuCloseIcon = this.doc.querySelector('[data-menu-close]');

    // Profile dropdown
    this.profileButton = this.doc.querySelector('[data-profile-dropdown-toggle]');
    this.profileDropdown = this.doc.querySelector('[data-profile-dropdown]');

    // Notifications
    this.notificationButton = this.doc.querySelector('[data-notifications-toggle]');
    this.notificationDropdown = this.doc.querySelector('[data-notifications-dropdown]');

    // Bound handlers for outside clicks / keys
    this._onDocumentClick = this._onDocumentClick.bind(this);
    this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
  }

  init() {
    this._initMobileMenu();
    this._initProfileDropdown();
    this._initNotifications();
    this._initSmoothScroll();
    this._initAutoHideAlerts();
    this._initLoadingButtons();

    // Global outside click / escape handlers
    this.doc.addEventListener('click', this._onDocumentClick);
    this.doc.addEventListener('keydown', this._onDocumentKeydown);

    console.log('🎉 Dashboard JavaScript loaded successfully (class)!');
  }

  // Helpers
  _isExpanded(el) {
    return el && el.getAttribute('aria-expanded') === 'true';
  }

  _setExpanded(el, val) {
    if (!el) return;
    el.setAttribute('aria-expanded', val ? 'true' : 'false');
  }

  _show(el) {
    if (!el) return;
    el.classList.remove('hidden');
  }

  _hide(el) {
    if (!el) return;
    el.classList.add('hidden');
  }

  // Mobile menu
  _initMobileMenu() {
    if (!this.mobileMenuButton || !this.mobileMenu) return;

    this.mobileMenuButton.addEventListener('click', () => {
      const expanded = this._isExpanded(this.mobileMenuButton);
      this._setExpanded(this.mobileMenuButton, !expanded);

      if (expanded) {
        this._hide(this.mobileMenu);
        this._swapMenuIcons(true);
      } else {
        this._show(this.mobileMenu);
        this._swapMenuIcons(false);
      }
    });
  }

  _swapMenuIcons(showOpen) {
    if (this.menuOpenIcon && this.menuCloseIcon) {
      if (showOpen) {
        this.menuOpenIcon.classList.remove('hidden');
        this.menuCloseIcon.classList.add('hidden');
      } else {
        this.menuOpenIcon.classList.add('hidden');
        this.menuCloseIcon.classList.remove('hidden');
      }
    }
  }

  // Profile dropdown
  _initProfileDropdown() {
    if (!this.profileButton || !this.profileDropdown) return;

    this.profileButton.addEventListener('click', (e) => {
      e.stopPropagation();
      const expanded = this._isExpanded(this.profileButton);
      this._setExpanded(this.profileButton, !expanded);
      if (expanded) this._hide(this.profileDropdown);
      else this._show(this.profileDropdown);
    });
  }

  // Notifications dropdown
  _initNotifications() {
    if (!this.notificationButton || !this.notificationDropdown) return;

    this.notificationButton.addEventListener('click', (e) => {
      e.stopPropagation();
      const expanded = this._isExpanded(this.notificationButton);
      this._setExpanded(this.notificationButton, !expanded);
      if (expanded) this._hide(this.notificationDropdown);
      else this._show(this.notificationDropdown);
    });
  }

  // Global click handler to close menus when clicking outside
  _onDocumentClick(event) {
    // Mobile menu
    if (this.mobileMenu && this.mobileMenuButton) {
      if (!this.mobileMenuButton.contains(event.target) && !this.mobileMenu.contains(event.target)) {
        this._hide(this.mobileMenu);
        this._setExpanded(this.mobileMenuButton, false);
        this._swapMenuIcons(true);
      }
    }

    // Profile dropdown
    if (this.profileButton && this.profileDropdown) {
      if (!this.profileButton.contains(event.target) && !this.profileDropdown.contains(event.target)) {
        this._hide(this.profileDropdown);
        this._setExpanded(this.profileButton, false);
      }
    }

    // Notifications dropdown
    if (this.notificationButton && this.notificationDropdown) {
      if (!this.notificationButton.contains(event.target) && !this.notificationDropdown.contains(event.target)) {
        this._hide(this.notificationDropdown);
        this._setExpanded(this.notificationButton, false);
      }
    }
  }

  // Escape key closes overlays
  _onDocumentKeydown(event) {
    if (event.key === 'Escape') {
      if (this.mobileMenu) {
        this._hide(this.mobileMenu);
        if (this.mobileMenuButton) {
          this._setExpanded(this.mobileMenuButton, false);
          this._swapMenuIcons(true);
        }
      }
      if (this.profileDropdown && this.profileButton) {
        this._hide(this.profileDropdown);
        this._setExpanded(this.profileButton, false);
      }
      if (this.notificationDropdown && this.notificationButton) {
        this._hide(this.notificationDropdown);
        this._setExpanded(this.notificationButton, false);
      }
    }
  }

  // Smooth scroll for hash anchors
  _initSmoothScroll() {
    this.doc.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (!href || href === '#') return;
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  // Auto-hide alerts
  _initAutoHideAlerts() {
    this.doc.querySelectorAll('[data-alert]').forEach(alert => {
      setTimeout(() => {
        alert.style.transition = 'opacity 0.5s ease-in-out';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      }, 5000);
    });
  }

  // Loading state for buttons/links
  _initLoadingButtons() {
    this.doc.querySelectorAll('button[type="submit"], a[data-loading]').forEach(el => {
      el.addEventListener('click', function () {
        if (this.disabled) return;
        const originalHtml = this.innerHTML;
        const loadingText = this.getAttribute('data-loading-text') || 'Loading...';

        this.disabled = true;
        this.innerHTML = `
          <svg class="inline w-4 h-4 mr-3 -ml-1 text-current animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          ${loadingText}
        `;

        // fallback re-enable after 3s
        setTimeout(() => {
          this.disabled = false;
          this.innerHTML = originalHtml;
        }, 3000);
      });
    });
  }
}
// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
  new AdminDashboard().init();
});
</script>

</body>

</html>
