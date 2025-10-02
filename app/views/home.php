<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= _get('app.name') ?> - Home</title>

  <!-- Asset Loading: Automatisch Dev/Production -->
  <?= Brick\Core\AssetHelper::viteAssets() ?>
</head>

<body>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-stone-900 mb-4">🔥 Welcome to <?= _get('app.name') ?>!</h1>
    <p class="text-lg text-gray-700 mb-6">This is the home page of our website.</p>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
      <h2 class="text-xl font-semibold text-blue-800 mb-2">Application Status</h2>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
          <strong>Environment:</strong> <?= _get('env') ?>
        </div>
        <div>
          <strong>Debug Mode:</strong> <?= _get('debug') ? 'Enabled' : 'Disabled' ?>
        </div>
        <div>
          <strong>Asset Mode:</strong> <?= _get('dev_mode') ? 'Development' : 'Production' ?>
        </div>
        <div>
          <strong>Version:</strong> <?= _get('app.version') ?>
        </div>
      </div>
      <?php if (_get('dev_mode')): ?>
        <p class="text-sm text-blue-600 mt-2">Assets werden von Vite Dev Server geladen (Hot Reload aktiv)</p>
      <?php else: ?>
        <p class="text-sm text-blue-600 mt-2">Kompilierte Assets werden geladen</p>
      <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Framework Features</h3>
        <ul class="list-disc list-inside text-gray-600 space-y-1">
          <li>PSR-4 Autoloading</li>
          <li>Flexible Router mit Middleware</li>
          <li>Asset Management (Dev/Prod)</li>
          <li>String-Alias Middleware Registry</li>
          <li>Global Config Helper (_get)</li>
        </ul>
      </div>

      <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Current Route</h3>
        <p class="text-gray-600">
          <strong>Method:</strong> <?= $_SERVER['REQUEST_METHOD'] ?? 'GET' ?><br>
          <strong>URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? '/' ?><br>
          <strong>App URL:</strong> <?= _get('app.url') ?>
        </p>
      </div>
    </div>

    <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
      <h3 class="text-lg font-semibold text-green-800 mb-2">Config Helper Examples</h3>
      <div class="text-sm text-green-700 space-y-1">
        <p><code>_get('app.name')</code> → <?= _get('app.name') ?></p>
        <p><code>_get('vite.dev_server')</code> → <?= _get('vite.dev_server') ?></p>
        <p><code>app_name()</code> → <?= app_name() ?></p>
        <p><code>is_dev()</code> → <?= is_dev() ? 'true' : 'false' ?></p>
      </div>
    </div>
  </div>
</body>

</html>