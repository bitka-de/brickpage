<?php
$currentPage = 'Settings';
include __DIR__ . '/../../bricks/dashboard/base.php';
?>
      <!-- Main Content -->
      <div class="p-4">
        <h2 class="text-lg font-semibold">Willkommen zurück, <?= htmlspecialchars($userName) ?>!</h2>
        <p class="mt-1 text-sm text-gray-600">Ihre E-Mail-Adresse lautet: <?= htmlspecialchars($userEmail) ?></p>
      </div>


<?php include __DIR__ . '/../../bricks/dashboard/end.php'; ?>