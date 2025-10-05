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
  <title><?= app('site.name') ?> - Admin Dashboard</title>
  <!-- Asset Loading: Automatisch Dev/Production -->
  <?= Brick\Core\AssetHelper::viteAssets() ?>
  <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/favicon-32x32.png">

</head>

<body class="bg-gradient-to-br from-slate-900/95 via-slate-800/90 to-slate-900/95 ">

  <section class="admin-layout">

    <!-- Header -->
    <?php include __DIR__ . '/../../bricks/dashboard/header.php'; ?>

    <!-- Content -->
    <div class="mx-auto admin-layout__content">
      <!-- Sidebar -->
      <?php include __DIR__ . '/../../bricks/dashboard/navbar.php'; ?>

      <!-- Main -->
      <main class="admin-layout__main overflow-clip">
        <section class="sticky top-0 z-10 flex items-center px-4 border-b h-11 border-slate-200 bg-slate-100"><b class="text-slate-500"><?= htmlspecialchars($currentPage ?? 'XXX') ?></b>

        </section>