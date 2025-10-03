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
              Mash
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
          <h1 class="text-3xl font-bold text-gray-900" style="color:green">Currywurst </h1>
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

    <!-- Content Layout -->
    <div class="px-4 mt-8 sm:px-0">
      <!-- Upper Section: Views and Quick Actions -->
      <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
        
        <!-- Application Views -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-4 py-5 sm:p-6">
            <!-- Header mit Suche und Add Button -->
            <div class="flex flex-col mb-4 sm:flex-row sm:items-center sm:justify-between">
              <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 sm:mb-0">Application Views</h3>
              <div class="flex flex-col gap-2 sm:flex-row">
                <!-- View Search -->
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                  </div>
                  <input 
                    type="text" 
                    id="viewSearch" 
                    placeholder="Views durchsuchen..." 
                    class="block w-full py-2 pl-10 pr-3 text-sm leading-5 placeholder-gray-500 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  >
                </div>
                <!-- Add View Button -->
                <button 
                  type="button"
                  onclick="openCreateViewModal()"
                  class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 whitespace-nowrap"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                  </svg>
                  Neue View
                </button>
              </div>
            </div>
            
            <!-- Views Statistik und Filter Info -->
            <div class="flex items-center justify-between mb-3">
              <p class="text-sm text-gray-600" id="viewCount">Lade Views...</p>
              <div id="viewNoResults" class="hidden px-3 py-1 text-xs font-medium text-orange-800 bg-orange-100 rounded-full">
                Keine Views gefunden
              </div>
            </div>
            
            <!-- Views Liste -->
            <div class="space-y-2" id="viewsList">
              <div class="flex items-center justify-center p-4 text-gray-500">
                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Lade Views...
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Quick Actions</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              
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

      <!-- Application Routes - Full Width Section -->
      <div class="mb-6 bg-white rounded-lg shadow">
        <div class="px-4 py-5 sm:p-6">
          <!-- Header mit Suche und Add Button -->
          <div class="flex flex-col mb-4 sm:flex-row sm:items-center sm:justify-between">
            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 sm:mb-0">Application Routes</h3>
            <div class="flex flex-col gap-2 sm:flex-row">
              <!-- Route Search -->
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                </div>
                <input 
                  type="text" 
                  id="routeSearch" 
                  placeholder="Routen durchsuchen..." 
                  class="block w-full py-2 pl-10 pr-3 text-sm leading-5 placeholder-gray-500 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
              </div>
              <!-- Add Route Button -->
              <button 
                type="button"
                onclick="openAddRouteModal()"
                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap"
              >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Neue Route
              </button>
            </div>
          </div>
            
            <div class="flow-root">
              <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Method</th>
                      <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Path</th>
                      <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Handler</th>
                      <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Middleware</th>
                      <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                    </tr>
                  </thead>
                  <tbody id="routesTableBody" class="bg-white divide-y divide-gray-200">
                    <?php
                    // Routes aus der Konfiguration laden
                    $routes = require CONFIG_DIR . '/routes.php';
                    foreach ($routes as $index => $route): 
                      $method = $route[0];
                      $path = $route[1];
                      $handler = $route[2];
                      $middlewares = $route[3] ?? [];
                      
                      // Method-spezifische Farben
                      $methodColor = match($method) {
                        'GET' => 'bg-green-100 text-green-800',
                        'POST' => 'bg-blue-100 text-blue-800',
                        'PUT' => 'bg-yellow-100 text-yellow-800',
                        'DELETE' => 'bg-red-100 text-red-800',
                        'PATCH' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-100 text-gray-800'
                      };
                    ?>
                    <tr class="hover:bg-gray-50 route-row" data-route-method="<?= strtolower($method) ?>" data-route-path="<?= strtolower($path) ?>" data-route-handler="<?= strtolower($handler) ?>">
                      <td class="px-3 py-2 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $methodColor ?>">
                          <?= htmlspecialchars($method) ?>
                        </span>
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <div class="font-mono text-sm font-medium text-gray-900">
                          <?= htmlspecialchars($path) ?>
                        </div>
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <div class="text-sm text-gray-600">
                          <?= htmlspecialchars($handler) ?>
                        </div>
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <?php if (!empty($middlewares)): ?>
                          <div class="flex flex-wrap gap-1">
                            <?php foreach ($middlewares as $middleware): ?>
                              <span class="inline-flex px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-md">
                                <?= htmlspecialchars($middleware) ?>
                              </span>
                            <?php endforeach; ?>
                          </div>
                        <?php else: ?>
                          <span class="text-xs text-gray-400">-</span>
                        <?php endif; ?>
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <div class="flex space-x-2">
                          <button 
                            onclick="editRoute(<?= $index ?>, '<?= htmlspecialchars($method) ?>', '<?= htmlspecialchars($path) ?>', '<?= htmlspecialchars($handler) ?>', <?= json_encode($middlewares) ?>)"
                            class="text-sm font-medium text-blue-600 hover:text-blue-900"
                          >
                            Bearbeiten
                          </button>
                          <button 
                            onclick="testRoute('<?= htmlspecialchars($method) ?>', '<?= htmlspecialchars($path) ?>')"
                            class="text-sm font-medium text-green-600 hover:text-green-900"
                          >
                            Testen
                          </button>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              
              <!-- No Results Message -->
              <div id="noRoutesMessage" class="hidden py-8 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Keine Routen gefunden</h3>
                <p class="mt-1 text-sm text-gray-500">Versuchen Sie einen anderen Suchbegriff.</p>
              </div>
            </div>
            <div class="mt-6">
              <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                  <span id="routeCount">Total: <?= count($routes) ?></span> routes configured
                </div>
                <a href="/debug/users" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                  Debug Users
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
  initRouteSearch();
});

// Route Search Functionality
function initRouteSearch() {
  const searchInput = document.getElementById('routeSearch');
  const routeRows = document.querySelectorAll('.route-row');
  const noResultsMessage = document.getElementById('noRoutesMessage');
  const routeCount = document.getElementById('routeCount');
  const totalRoutes = routeRows.length;

  if (!searchInput) return;

  searchInput.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase().trim();
    let visibleCount = 0;

    routeRows.forEach(row => {
      const method = row.dataset.routeMethod || '';
      const path = row.dataset.routePath || '';
      const handler = row.dataset.routeHandler || '';
      
      const isVisible = method.includes(searchTerm) || 
                       path.includes(searchTerm) || 
                       handler.includes(searchTerm);

      if (isVisible) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    // Update count and show/hide no results message
    if (searchTerm === '') {
      routeCount.textContent = `Total: ${totalRoutes}`;
      noResultsMessage.classList.add('hidden');
    } else {
      routeCount.textContent = `Gefunden: ${visibleCount} von ${totalRoutes}`;
      if (visibleCount === 0) {
        noResultsMessage.classList.remove('hidden');
      } else {
        noResultsMessage.classList.add('hidden');
      }
    }
  });
}

// Route Management Functions
function openAddRouteModal() {
  const modal = document.createElement('div');
  modal.className = 'fixed inset-0 bg-gray-600/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50';
  modal.innerHTML = `
    <div class="relative w-11/12 p-5 mx-auto bg-white border rounded-md shadow-lg top-20 md:w-2/3 lg:w-1/2">
      <div class="mt-3">
        <h3 class="mb-4 text-lg font-medium text-gray-900">Neue Route hinzufügen</h3>
        <form id="addRouteForm" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">HTTP Method</label>
            <select id="routeMethod" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="GET">GET</option>
              <option value="POST">POST</option>
              <option value="PUT">PUT</option>
              <option value="DELETE">DELETE</option>
              <option value="PATCH">PATCH</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Path</label>
            <input type="text" id="routePath" placeholder="/example" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          
          <!-- Target Type Toggle -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Ziel</label>
            <div class="flex p-1 bg-gray-100 rounded-lg">
              <button type="button" id="viewToggle" onclick="toggleHandlerType('view')" class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-md shadow">
                View
              </button>
              <button type="button" id="controllerToggle" onclick="toggleHandlerType('controller')" class="flex-1 px-3 py-2 text-sm font-medium text-gray-500 rounded-md">
                Controller
              </button>
            </div>
          </div>
          
          <!-- View Selection -->
          <div id="viewSelection" class="space-y-2">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">View auswählen</label>
              <button type="button" onclick="openCreateViewModal()" class="px-2 py-1 text-xs font-medium text-blue-600 rounded bg-blue-50 hover:bg-blue-100">
                + Neue View
              </button>
            </div>
            <select id="viewSelect" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="">-- View auswählen --</option>
              <option value="home">home.php</option>
              <option value="admin/dashboard">admin/dashboard.php</option>
              <option value="auth/login">auth/login.php</option>
              <option value="elefant">elefant.php</option>
            </select>
          </div>
          
          <!-- Controller Selection -->
          <div id="controllerSelection" class="hidden space-y-2">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">Controller auswählen</label>
              <button type="button" onclick="openCreateControllerModal()" class="px-2 py-1 text-xs font-medium text-blue-600 rounded bg-blue-50 hover:bg-blue-100">
                + Neuer Controller
              </button>
            </div>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
              <select id="controllerSelect" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Controller auswählen --</option>
                <option value="LoginController">LoginController</option>
              </select>
              <input type="text" id="controllerMethod" placeholder="Methode (z.B. index)" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Middleware (optional)</label>
            <input type="text" id="routeMiddleware" placeholder="auth, cors (komma-getrennt)" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div class="flex items-center justify-end pt-4 space-x-3">
            <button type="button" onclick="closeAddRouteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
              Abbrechen
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
              Route hinzufügen
            </button>
          </div>
        </form>
      </div>
    </div>
  `;
  
  document.body.appendChild(modal);
  
  // Handle form submission
  document.getElementById('addRouteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    addNewRoute();
  });
  
  // Close modal on outside click
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeAddRouteModal();
    }
  });
}

function toggleHandlerType(type) {
  const viewToggle = document.getElementById('viewToggle');
  const controllerToggle = document.getElementById('controllerToggle');
  const viewSelection = document.getElementById('viewSelection');
  const controllerSelection = document.getElementById('controllerSelection');
  
  if (type === 'view') {
    viewToggle.className = 'flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-md shadow';
    controllerToggle.className = 'flex-1 px-3 py-2 text-sm font-medium text-gray-500 rounded-md';
    viewSelection.classList.remove('hidden');
    controllerSelection.classList.add('hidden');
  } else {
    controllerToggle.className = 'flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-md shadow';
    viewToggle.className = 'flex-1 px-3 py-2 text-sm font-medium text-gray-500 rounded-md';
    controllerSelection.classList.remove('hidden');
    viewSelection.classList.add('hidden');
  }
}

function closeAddRouteModal() {
  const modal = document.querySelector('.fixed.inset-0');
  if (modal) {
    modal.remove();
  }
}

function addNewRoute() {
  const method = document.getElementById('routeMethod').value;
  const path = document.getElementById('routePath').value.trim();
  const middlewareInput = document.getElementById('routeMiddleware').value.trim();
  
  // Determine handler based on toggle state
  let handler = '';
  const viewToggle = document.getElementById('viewToggle');
  const isViewMode = viewToggle.className.includes('bg-white');
  
  if (isViewMode) {
    const selectedView = document.getElementById('viewSelect').value;
    if (!selectedView) {
      alert('Bitte wählen Sie eine View aus.');
      return;
    }
    handler = selectedView;
  } else {
    const selectedController = document.getElementById('controllerSelect').value;
    const controllerMethod = document.getElementById('controllerMethod').value.trim();
    
    if (!selectedController || !controllerMethod) {
      alert('Bitte wählen Sie einen Controller und geben Sie eine Methode an.');
      return;
    }
    handler = `${selectedController}.${controllerMethod}`;
  }
  
  if (!path) {
    alert('Bitte geben Sie einen Pfad an.');
    return;
  }
  
  // Validate path format
  if (!path.startsWith('/')) {
    alert('Der Pfad muss mit "/" beginnen.');
    return;
  }
  
  const middlewares = middlewareInput ? middlewareInput.split(',').map(m => m.trim()).filter(m => m) : [];
  
  // Here you would normally send this to a backend endpoint
  // For now, we'll show a preview
  const routeData = {
    method: method,
    path: path,
    handler: handler,
    middlewares: middlewares
  };
  
  alert('Route wird hinzugefügt:\\n\\nMethod: ' + method + '\\nPath: ' + path + '\\nHandler: ' + handler + '\\nMiddleware: ' + (middlewares.join(', ') || 'Keine') + '\\n\\nHinweis: Diese Funktion speichert die Route noch nicht dauerhaft.');
  
  closeAddRouteModal();
}

function editRoute(index, method, path, handler, middlewares) {
  alert('Route bearbeiten:\\n\\nIndex: ' + index + '\\nMethod: ' + method + '\\nPath: ' + path + '\\nHandler: ' + handler + '\\nMiddleware: ' + (middlewares.join(', ') || 'Keine') + '\\n\\nHinweis: Bearbeitungsfunktion noch nicht implementiert.');
}

function testRoute(method, path) {
  if (method === 'GET') {
    // Open route in new tab
    const url = window.location.origin + path;
    window.open(url, '_blank');
  } else {
    alert('Route testen:\\n\\nMethod: ' + method + '\\nPath: ' + path + '\\n\\nHinweis: Nur GET-Routen können direkt getestet werden.');
  }
}

// View Management Functions
function openCreateViewModal() {
  const modal = document.createElement('div');
  modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
  modal.innerHTML = `
    <div class="relative w-11/12 p-5 mx-auto bg-white border rounded-md shadow-lg top-20 md:w-1/2 lg:w-1/3">
      <div class="mt-3">
        <h3 class="mb-4 text-lg font-medium text-gray-900">Neue View erstellen</h3>
        <form id="createViewForm" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">View Name</label>
            <input type="text" id="viewName" placeholder="z.B. contact, about, products/detail" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="mt-1 text-xs text-gray-500">Ordner werden automatisch erstellt (z.B. products/detail erstellt products/detail.php)</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">View Template</label>
            <select id="viewTemplate" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="basic">Basic HTML Template</option>
              <option value="form">Formular Template</option>
              <option value="table">Tabellen Template</option>
              <option value="empty">Leere View</option>
            </select>
          </div>
          <div class="flex items-center justify-end pt-4 space-x-3">
            <button type="button" onclick="closeCreateViewModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
              Abbrechen
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
              View erstellen
            </button>
          </div>
        </form>
      </div>
    </div>
  `;
  
  document.body.appendChild(modal);
  
  document.getElementById('createViewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    createNewView();
  });
  
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeCreateViewModal();
    }
  });
}

function closeCreateViewModal() {
  const modal = document.querySelector('.fixed.inset-0');
  if (modal) {
    modal.remove();
  }
}

function createNewView() {
  const viewName = document.getElementById('viewName').value.trim();
  const viewTemplate = document.getElementById('viewTemplate').value;
  
  if (!viewName) {
    alert('Bitte geben Sie einen View-Namen an.');
    return;
  }
  
  // Validate view name
  if (!/^[a-zA-Z0-9/_-]+$/.test(viewName)) {
    alert('View-Name darf nur Buchstaben, Zahlen, Bindestriche, Unterstriche und Schrägstriche enthalten.');
    return;
  }
  
  // Show loading state
  const submitBtn = document.querySelector('#createViewForm button[type="submit"]');
  const originalText = submitBtn.textContent;
  submitBtn.textContent = 'Wird erstellt...';
  submitBtn.disabled = true;
  
  // Send request to backend
  fetch('/api/views/create', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      name: viewName,
      template: viewTemplate
    })
  })
  .then(response => {
    console.log('Response status:', response.status);
    console.log('Response headers:', response.headers);
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    return response.json();
  })
  .then(data => {
    console.log('Response data:', data);
    
    if (data.success) {
      // Success - show success message and reload dashboard
      alert('View "' + viewName + '.php" wurde erfolgreich erstellt!');
      
      // Close modal first
      closeCreateViewModal();
      
      // Reload the dashboard to show updated routes/views
      setTimeout(() => {
        window.location.reload();
      }, 500);
    } else {
      // Error from backend
      alert('Fehler: ' + (data.error || 'Unbekannter Fehler'));
    }
  })
  .catch(error => {
    console.error('Fetch error:', error);
    alert('Ein Fehler ist aufgetreten beim Erstellen der View: ' + error.message);
  })
  .finally(() => {
    // Reset button state
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  });
}

// Controller Management Functions
function openCreateControllerModal() {
  const modal = document.createElement('div');
  modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
  modal.innerHTML = `
    <div class="relative w-11/12 p-5 mx-auto bg-white border rounded-md shadow-lg top-20 md:w-1/2 lg:w-1/3">
      <div class="mt-3">
        <h3 class="mb-4 text-lg font-medium text-gray-900">Neuen Controller erstellen</h3>
        <form id="createControllerForm" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Controller Name</label>
            <input type="text" id="controllerName" placeholder="z.B. UserController, ProductController" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="mt-1 text-xs text-gray-500">Name sollte mit "Controller" enden</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Standard Methoden</label>
            <div class="mt-2 space-y-2">
              <label class="inline-flex items-center">
                <input type="checkbox" id="includeIndex" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">index() - Übersicht anzeigen</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" id="includeShow" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">show() - Einzelnen Eintrag anzeigen</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" id="includeCreate" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">create() - Formular anzeigen</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" id="includeStore" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">store() - Daten speichern</span>
              </label>
            </div>
          </div>
          <div class="flex items-center justify-end pt-4 space-x-3">
            <button type="button" onclick="closeCreateControllerModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
              Abbrechen
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
              Controller erstellen
            </button>
          </div>
        </form>
      </div>
    </div>
  `;
  
  document.body.appendChild(modal);
  
  document.getElementById('createControllerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    createNewController();
  });
  
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeCreateControllerModal();
    }
  });
}

function closeCreateControllerModal() {
  const modal = document.querySelector('.fixed.inset-0');
  if (modal) {
    modal.remove();
  }
}

function createNewController() {
  const controllerName = document.getElementById('controllerName').value.trim();
  
  if (!controllerName) {
    alert('Bitte geben Sie einen Controller-Namen an.');
    return;
  }
  
  // Validate controller name
  if (!/^[A-Z][a-zA-Z0-9]*Controller$/.test(controllerName)) {
    alert('Controller-Name muss mit einem Großbuchstaben beginnen und mit "Controller" enden.');
    return;
  }
  
  const methods = [];
  if (document.getElementById('includeIndex').checked) methods.push('index');
  if (document.getElementById('includeShow').checked) methods.push('show');
  if (document.getElementById('includeCreate').checked) methods.push('create');
  if (document.getElementById('includeStore').checked) methods.push('store');
  
  // Here you would send this to a backend endpoint to create the controller file
  alert('Controller wird erstellt:\\n\\nName: ' + controllerName + '\\nMethoden: ' + methods.join(', ') + '\\n\\nHinweis: Diese Funktion erstellt die Controller-Datei noch nicht.');
  
  // Add to dropdown for immediate use
  const controllerSelect = document.getElementById('controllerSelect');
  const option = document.createElement('option');
  option.value = controllerName;
  option.textContent = controllerName;
  controllerSelect.appendChild(option);
  controllerSelect.value = controllerName;
  
  closeCreateControllerModal();
  
  // TODO: When controller creation backend is implemented, 
  // reload dashboard here like the view creation:
  // setTimeout(() => { window.location.reload(); }, 500);
}

// Views Management Functions
function loadViews() {
  fetch('/api/views/list')
    .then(response => response.json())
    .then(data => {
      const viewsList = document.getElementById('viewsList');
      
      if (data.success && data.views) {
        if (data.views.length === 0) {
          viewsList.innerHTML = `
            <div class="py-4 text-center text-gray-500">
              <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <p class="text-sm">Keine Views gefunden</p>
            </div>
          `;
        } else {
          let viewsHtml = '';
          data.views.forEach(view => {
            const isProtected = ['admin/dashboard', 'auth/login', 'home'].includes(view.name);
            viewsHtml += `
              <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex-1">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">${view.name}.php</span>
                    ${isProtected ? '<span class="px-2 py-1 ml-2 text-xs font-medium text-yellow-800 bg-yellow-100 rounded">Geschützt</span>' : ''}
                  </div>
                  <p class="ml-6 text-xs text-gray-500">Geändert: ${view.modified} • ${Math.round(view.size / 1024)} KB</p>
                </div>
                <div class="flex items-center space-x-2">
                  <button onclick="previewView(${JSON.stringify(view).replace(/"/g, '&quot;')})" class="p-1 text-blue-600 hover:text-blue-800" title="Vorschau">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                  </button>
                  <button onclick="openInEditor('${view.name}')" class="p-1 text-green-600 hover:text-green-800" title="Im Editor öffnen">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  ${!isProtected ? `
                  <button onclick="deleteView('${view.name}')" class="p-1 text-red-600 hover:text-red-800" title="Löschen">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                  ` : ''}
                </div>
              </div>
            `;
          });
          viewsList.innerHTML = viewsHtml;
        }
      } else {
        viewsList.innerHTML = `
          <div class="py-4 text-center text-red-500">
            <p class="text-sm">Fehler beim Laden der Views: ${data.error || 'Unbekannter Fehler'}</p>
          </div>
        `;
      }
    })
    .catch(error => {
      console.error('Error loading views:', error);
      const viewsList = document.getElementById('viewsList');
      viewsList.innerHTML = `
        <div class="py-4 text-center text-red-500">
          <p class="text-sm">Fehler beim Laden der Views</p>
        </div>
      `;
    });
}

// Views Search Functions
let allViews = []; // Store all views for filtering

function updateLoadViewsForSearch() {
  const originalLoadViews = loadViews;
  
  loadViews = function() {
    fetch('/api/views/list')
      .then(response => response.json())
      .then(data => {
        if (data.success && data.views) {
          allViews = data.views; // Store for filtering
          displayViewsWithSearch(allViews);
          updateViewCount(allViews.length, allViews.length);
        } else {
          displayViewsError(data.error || 'Unbekannter Fehler');
        }
      })
      .catch(error => {
        console.error('Error loading views:', error);
        displayViewsError('Fehler beim Laden der Views');
      });
  };
}

function displayViewsWithSearch(views) {
  const viewsList = document.getElementById('viewsList');
  
  if (views.length === 0) {
    viewsList.innerHTML = `
      <div class="py-4 text-center text-gray-500">
        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="text-sm">Keine Views gefunden</p>
      </div>
    `;
  } else {
    let viewsHtml = '';
    views.forEach(view => {
      const isProtected = ['admin/dashboard', 'auth/login', 'home'].includes(view.name);
      
      // Build routes info
      let routesHtml = '';
      if (view.routes && view.routes.length > 0) {
        const routesList = view.routes.map(route => 
          `<span class="inline-flex items-center px-2 py-1 mr-1 text-xs font-medium text-blue-800 bg-blue-100 rounded">${route.method} ${route.uri}</span>`
        ).join('');
        routesHtml = `<div class="mt-1 ml-6"><span class="text-xs text-gray-600">Routen: </span>${routesList}</div>`;
      } else {
        routesHtml = `<div class="mt-1 ml-6"><span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded">Keine Routen</span></div>`;
      }
      
      viewsHtml += `
        <div class="p-3 mb-2 border border-gray-200 rounded-lg view-item bg-gray-50 hover:bg-gray-100" data-view-name="${view.name.toLowerCase()}">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-sm font-medium text-gray-900">${view.name}.php</span>
                ${isProtected ? '<span class="px-2 py-1 ml-2 text-xs font-medium text-yellow-800 bg-yellow-100 rounded">Geschützt</span>' : ''}
              </div>
              <p class="ml-6 text-xs text-gray-500">Geändert: ${view.modified} • ${Math.round(view.size / 1024)} KB</p>
              ${routesHtml}
            </div>
            <div class="flex items-center ml-4 space-x-2">
            <button onclick="previewView(${JSON.stringify(view).replace(/"/g, '&quot;')})" class="p-1 text-blue-600 hover:text-blue-800" title="Vorschau">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
            <button onclick="openInEditor('${view.name}')" class="p-1 text-green-600 hover:text-green-800" title="Im Editor öffnen">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            ${!isProtected ? `
            <button onclick="deleteView('${view.name}')" class="p-1 text-red-600 hover:text-red-800" title="Löschen">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
            ` : ''}
            </div>
          </div>
        </div>
      `;
    });
    viewsList.innerHTML = viewsHtml;
  }
}

function updateViewCount(visibleCount, totalCount) {
  const viewCount = document.getElementById('viewCount');
  const noResultsMessage = document.getElementById('viewNoResults');
  
  if (totalCount === 0) {
    viewCount.textContent = 'Keine Views vorhanden';
    noResultsMessage.classList.add('hidden');
  } else if (visibleCount === totalCount) {
    viewCount.textContent = `${totalCount} Views`;
    noResultsMessage.classList.add('hidden');
  } else {
    viewCount.textContent = `Gefunden: ${visibleCount} von ${totalCount}`;
    if (visibleCount === 0) {
      noResultsMessage.classList.remove('hidden');
    } else {
      noResultsMessage.classList.add('hidden');
    }
  }
}

function initViewSearch() {
  const searchInput = document.getElementById('viewSearch');
  if (!searchInput) return;
  
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    
    if (searchTerm === '') {
      // Show all views
      displayViewsWithSearch(allViews);
      updateViewCount(allViews.length, allViews.length);
    } else {
      // Filter views
      const filteredViews = allViews.filter(view => 
        view.name.toLowerCase().includes(searchTerm) ||
        view.file.toLowerCase().includes(searchTerm)
      );
      
      displayViewsWithSearch(filteredViews);
      updateViewCount(filteredViews.length, allViews.length);
    }
  });
}

function deleteView(viewName) {
  if (!confirm('Möchten Sie die View "' + viewName + '.php" wirklich löschen?\\n\\nDieser Vorgang kann nicht rückgängig gemacht werden.')) {
    return;
  }
  
  fetch('/api/views/delete', {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      name: viewName
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('View "' + viewName + '.php" wurde erfolgreich gelöscht!');
      loadViews(); // Reload views list
    } else {
      alert('Fehler beim Löschen: ' + (data.error || 'Unbekannter Fehler'));
    }
  })
  .catch(error => {
    console.error('Error deleting view:', error);
    alert('Ein Fehler ist aufgetreten beim Löschen der View.');
  });
}

function previewView(viewData) {
  const routes = viewData.routes || [];
  
  if (routes.length === 0) {
    // Keine Route zugeordnet - Info-Dialog anzeigen
    showNoRouteDialog(viewData.name);
  } else if (routes.length === 1) {
    // Eine Route - direkt öffnen
    const route = routes[0];
    const url = addPreviewParameter(route.uri, route.handler);
    window.open(url, '_blank');
  } else {
    // Mehrere Routen - Auswahl-Dialog anzeigen
    showRouteSelectionDialog(viewData.name, routes);
  }
}

function showNoRouteDialog(viewName) {
  const modal = document.createElement('div');
  modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
  modal.innerHTML = `
    <div class="relative p-5 mx-auto bg-white border rounded-md shadow-lg top-20 w-96">
      <div class="mt-3 text-center">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-yellow-100 rounded-full">
          <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <h3 class="mt-2 text-lg font-medium leading-6 text-gray-900">Keine Route zugeordnet</h3>
        <div class="py-3 mt-2 px-7">
          <p class="text-sm text-gray-500">
            Die View <strong>${viewName}.php</strong> ist noch keiner Route zugeordnet.
            <br><br>
            Um diese View anzuzeigen, müssen Sie zuerst eine Route in der Routen-Konfiguration hinzufügen.
          </p>
        </div>
        <div class="items-center px-4 py-3">
          <button onclick="closeModal(this)" class="w-full px-4 py-2 text-base font-medium text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Verstanden
          </button>
        </div>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
}

function showRouteSelectionDialog(viewName, routes) {
  const modal = document.createElement('div');
  modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
  
  const routesList = routes.map(route => `
    <button onclick="openRoute('${route.uri}', '${route.handler}')" class="flex items-center justify-between w-full p-3 text-left border-b border-gray-200 hover:bg-gray-50">
      <div>
        <span class="font-medium text-gray-900">${route.method} ${route.uri}</span>
        ${route.middlewares && route.middlewares.length > 0 ? 
          `<div class="mt-1 text-xs text-gray-500">Middleware: ${route.middlewares.join(', ')}</div>` : 
          ''
        }
      </div>
      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </button>
  `).join('');
  
  modal.innerHTML = `
    <div class="relative p-5 mx-auto bg-white border rounded-md shadow-lg top-20 w-96">
      <div class="mt-3">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
          </svg>
        </div>
        <h3 class="mt-2 text-lg font-medium leading-6 text-center text-gray-900">Route auswählen</h3>
        <div class="px-2 py-3 mt-2">
          <p class="mb-4 text-sm text-center text-gray-500">
            Die View <strong>${viewName}.php</strong> ist über mehrere Routen erreichbar.
            Wählen Sie eine Route für die Vorschau:
          </p>
          <div class="overflow-hidden border border-gray-200 rounded-md">
            ${routesList}
          </div>
        </div>
        <div class="items-center px-4 py-3">
          <button onclick="closeModal(this)" class="w-full px-4 py-2 text-base font-medium text-white bg-gray-500 rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
            Abbrechen
          </button>
        </div>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
}

function openRoute(uri, handler) {
  const url = addPreviewParameter(uri, handler);
  window.open(url, '_blank');
  // Close modal after opening route
  const modal = document.querySelector('.fixed.inset-0');
  if (modal) modal.remove();
}

function addPreviewParameter(uri, handler) {
  const baseUrl = window.location.origin + uri;
  
  // Check if this is a controller-based route (not a direct view)
  if (handler && !handler.startsWith('view.')) {
    // Add preview parameter for controller routes to bypass redirects
    const separator = uri.includes('?') ? '&' : '?';
    return baseUrl + separator + 'preview=true';
  }
  
  // For direct view routes, no preview parameter needed
  return baseUrl;
}

function closeModal(button) {
  const modal = button.closest('.fixed.inset-0');
  if (modal) modal.remove();
}

function openInEditor(viewName) {
  // Convert slashes to colons to avoid route conflicts
  const encodedViewName = viewName.replace(/\//g, ':');
  const editorUrl = `/editor/view/${encodedViewName}`;
  window.open(editorUrl, '_blank');
}

// Load views when page loads
document.addEventListener('DOMContentLoaded', function() {
  updateLoadViewsForSearch(); // Initialize search functionality
  loadViews(); // Load views
  initViewSearch(); // Initialize search input
});
</script>

</body>

</html>
