<?php
// Aktuellen Benutzer aus Session laden
use Brick\Controller\LoginController;

$loginController = new LoginController();
$currentUser = $loginController->getCurrentUser();
$userName = $currentUser ? $currentUser['name'] : 'Unbekannter Benutzer';
$userEmail = $currentUser ? $currentUser['email'] : '';
?>
<!DOCTYPE html>
<html lang="<?= app('site.language'); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= app('site.name') ?> - Settings</title>
  <!-- Asset Loading: Automatisch Dev/Production -->
  <?= Brick\Core\AssetHelper::viteAssets() ?>
  <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/favicon-32x32.png">

</head>

<body class="bg-gray-100">

  <?php include __DIR__ . '/../../bricks/dashboard/navbar.php'; ?>

  <div class="container mx-auto mt-4">
    Hier werden später die Settings verarbeitet
  </div>
</body>

</html>