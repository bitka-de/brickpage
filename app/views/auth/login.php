<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= _get('app.name') ?> - Anmelden</title>
  <?= Brick\Core\AssetHelper::viteAssets() ?>
</head>

<body class="login-container">

  <div class="w-full max-w-sm space-y-8">

    <!-- Header -->
    <div class="login-header">
      <div class="login-logo">
        <svg class="text-white size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
      </div>
      <div class="space-y-2">
        <h1 class="login-title">
          Willkommen zurück
        </h1>
        <p class="login-subtitle">
          Melden Sie sich bei Ihrem <?= _get('app.name') ?> Konto an
        </p>
      </div>
    </div>

    <!-- Login Form -->
    <div class="login-card">
      <form class="login-form" action="/login" method="POST">

        <!-- Email Field -->
        <div class="login-field">
          <label for="email" class="login-label">
            E-Mail-Adresse
          </label>
          <div class="login-input-wrapper">
            <div class="login-input-icon">
              <svg class="text-gray-400 size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </div>
            <input
              id="email"
              name="email"
              type="email"
              autocomplete="email"
              required
              class="login-input"
              placeholder="ihre@email.de">
          </div>
        </div>

        <!-- Password Field -->
        <div class="login-field">
          <label for="password" class="login-label">
            Passwort
          </label>
          <div class="login-input-wrapper">
            <div class="login-input-icon">
              <svg class="text-gray-400 size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              required
              class="login-input"
              placeholder="••••••••">
          </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="login-checkbox-wrapper">
          <label class="login-checkbox-label">
            <input type="checkbox" class="login-checkbox">
            <span class="text-gray-700">Angemeldet bleiben</span>
          </label>
          <a href="#" class="login-forgot-link">
            Passwort vergessen?
          </a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="login-submit-button">
          <span class="flex items-center justify-center gap-2">
            Anmelden
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </span>
        </button>
      </form>
    </div>

    <!-- Navigation Links -->
    <div class="login-nav-links">
      <p class="text-sm text-gray-600">
        <a href="/" class="login-back-link">
          <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Zurück zur Webseite
        </a>
      </p>
    </div>

    <!-- Development Info -->
    <?php if (_get('debug')): ?>
      <div class="login-debug">
        <div class="login-debug-content">
          <svg class="login-debug-icon" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <div class="login-debug-text">
            <h3 class="login-debug-title">Entwicklungsmodus</h3>
            <p class="login-debug-info">
              Umgebung: <?= _get('env') ?> | Debug: <?= _get('debug') ? 'An' : 'Aus' ?>
            </p>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</body>

</html>