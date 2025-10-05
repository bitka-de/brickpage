<?php
$currentPage = 'Dashboard';
include __DIR__ . '/../../bricks/dashboard/base.php';
?>
<!-- Main Content -->
<div class="grid grid-cols-4 gap-4 p-4">

  <div class="col-span-2 p-4">
    <h2 class="mb-1 text-2xl font-bold">Willkommen zurück, <?= htmlspecialchars($userName) ?>!</h2>
    <p class="mb-3 text-sm opacity-80">Wähle eine Seite, um loszulegen.</p>


    <div class="p-4 mt-6 border bg-slate-50 border-slate-200">
      <div class="flex items-center justify-between mb-3">
      <div>
        <div class="mb-1 text-sm text-gray-400">Schnellzugriffe</div>
        <div class="text-lg font-semibold">Aktionen</div>
      </div>
      <a href="/admin" class="text-xs text-indigo-400 hover:underline">Übersicht</a>
      </div>

      <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
      <a href="/admin/pages" aria-label="Seiten verwalten" class="flex items-center gap-4 p-3 transition transform border border-transparent group rounded-2xl bg-white/4 hover:border-white/6 hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <span class="flex items-center justify-center w-12 h-12 text-white rounded-lg shadow" style="background:linear-gradient(135deg,#6366f1,#60a5fa);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
        </span>
        <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold truncate">Seiten</div>
        <div class="text-xs text-gray-400 truncate">Alle Seiten verwalten</div>
        </div>
        <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18l6-6-6-6"/></svg>
      </a>

      <a href="/admin/analytics" aria-label="Analytics" class="flex items-center gap-4 p-3 transition transform border border-transparent group rounded-2xl bg-white/4 hover:border-white/6 hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400">
        <span class="flex items-center justify-center w-12 h-12 text-white rounded-lg shadow" style="background:linear-gradient(135deg,#10b981,#059669);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3v18h18"/><path d="M7 13v6"/><path d="M12 9v10"/><path d="M17 5v14"/></svg>
        </span>
        <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold truncate">Analytics</div>
        <div class="text-xs text-gray-400 truncate">Traffic & Kennzahlen</div>
        </div>
        <svg class="w-4 h-4 text-gray-300 group-hover:text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18l6-6-6-6"/></svg>
      </a>

      <a href="/admin/pages/new" aria-label="Neue Seite erstellen" class="flex items-center gap-4 p-3 transition transform border border-transparent group rounded-2xl bg-white/4 hover:border-white/6 hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-amber-400">
        <span class="flex items-center justify-center w-12 h-12 text-white rounded-lg shadow" style="background:linear-gradient(135deg,#f97316,#fb923c);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        </span>
        <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold truncate">Neue Seite</div>
        <div class="text-xs text-gray-400 truncate">Schnell erstellen</div>
        </div>
        <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18l6-6-6-6"/></svg>
      </a>

      <a href="/admin/media" aria-label="Medien" class="flex items-center gap-4 p-3 transition transform border border-transparent group rounded-2xl bg-white/4 hover:border-white/6 hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-rose-400">
        <span class="flex items-center justify-center w-12 h-12 text-white rounded-lg shadow" style="background:linear-gradient(135deg,#ef4444,#f97316);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 14s1.5-2 3-2 3 2 3 2"/></svg>
        </span>
        <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold truncate">Medien</div>
        <div class="text-xs text-gray-400 truncate">Bilder & Dateien</div>
        </div>
        <svg class="w-4 h-4 text-gray-300 group-hover:text-rose-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18l6-6-6-6"/></svg>
      </a>

      <a href="/admin/users" aria-label="Benutzer" class="flex items-center gap-4 p-3 transition transform border border-transparent group rounded-2xl bg-white/4 hover:border-white/6 hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
        <span class="flex items-center justify-center w-12 h-12 text-white rounded-lg shadow" style="background:linear-gradient(135deg,#8b5cf6,#a78bfa);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </span>
        <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold truncate">Benutzer</div>
        <div class="text-xs text-gray-400 truncate">Konten & Rollen</div>
        </div>
        <svg class="w-4 h-4 text-gray-300 group-hover:text-purple-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18l6-6-6-6"/></svg>
      </a>

      <a href="/admin/settings" aria-label="Einstellungen" class="flex items-center gap-4 p-3 transition transform border border-transparent group rounded-2xl bg-white/4 hover:border-white/6 hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-slate-400">
        <span class="flex items-center justify-center w-12 h-12 text-white rounded-lg shadow" style="background:linear-gradient(135deg,#64748b,#475569);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 15.5A3.5 3.5 0 1 0 12 8.5a3.5 3.5 0 0 0 0 7z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06A2 2 0 1 1 2.31 17.9l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09c.7 0 1.28-.37 1.51-1a1.65 1.65 0 0 0-.33-1.82l-.06-.06A2 2 0 1 1 6.1 2.31l.06.06a1.65 1.65 0 0 0 1.82.33H8a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09c0 .7.37 1.28 1 1.51h.02a1.65 1.65 0 0 0 1.82-.33l.06-.06A2 2 0 1 1 21.69 6.1l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.7 0 1.28.37 1.51 1H21a2 2 0 1 1 0 4h-.09c-.7 0-1.28.37-1.51 1z"/></svg>
        </span>
        <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold truncate">Einstellungen</div>
        <div class="text-xs text-gray-400 truncate">System & Konfiguration</div>
        </div>
        <svg class="w-4 h-4 text-gray-300 group-hover:text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18l6-6-6-6"/></svg>
      </a>
      </div>
    </div>



  </div>
  <div class="col-span-1 p-4 bg-slate-50">
    <?php
    $logs = [
      ['user_id' => 123, 'action' => 'eingeloggt', 'time' => new DateTimeImmutable('-3 minutes')],
      ['user_id' => 456, 'action' => 'Seite aktualisiert', 'time' => new DateTimeImmutable('-2 hours')],
      ['user_id' => 123, 'action' => 'Kommentar gepostet', 'time' => new DateTimeImmutable('-1 day')],
    ];

    function relative_time(\DateTimeInterface $t): string {
      $s = max(0, time() - $t->getTimestamp());
      if ($s < 10) return 'gerade eben';
      if ($s < 60) return "vor {$s}s";
      if ($s < 3600) return 'vor ' . floor($s / 60) . 'm';
      if ($s < 86400) return 'vor ' . floor($s / 3600) . 'h';
      return 'vor ' . floor($s / 86400) . 'd';
    }

    function avatar_style(string $key): string {
      $h = (abs(crc32($key)) % 360);
      $h2 = ($h + 40) % 360;
      return "background-image: linear-gradient(135deg, hsl({$h} 75% 56%), hsl({$h2} 65% 46%));";
    }

    function initials_from_id($id): string {
      $s = preg_replace('/[^A-Za-z]/', '', base_convert((string)$id, 10, 36));
      $s = strtoupper($s ?: (string)$id);
      return substr($s, 0, 2);
    }

    $count = count($logs);
    ?>
    <div class="p-4 rounded-2xl bg-white/4 ring-1 ring-white/6 backdrop-blur-sm">
      <div class="flex items-center justify-between mb-3">
        <div>
          <h3 class="text-sm font-semibold">Aktivitäten</h3>
          <p class="text-xs text-gray-400">Neueste oben</p>
        </div>
        <div class="text-xs text-gray-300"><?= $count ?></div>
      </div>

      <?php if ($count === 0): ?>
        <div class="py-6 text-xs text-center text-gray-400">Keine Aktivitäten</div>
      <?php else: ?>
        <ul class="space-y-3">
          <?php foreach ($logs as $log): $dt = $log['time']; ?>
            <li class="flex items-start gap-3 p-2 rounded-lg bg-white/2">
              <a href="/admin/users/<?= urlencode($log['user_id']) ?>" class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white rounded-lg shadow-sm" style="<?= avatar_style((string)$log['user_id']) ?>" aria-label="Profil von User <?= htmlspecialchars($log['user_id']) ?>">
                <?= htmlspecialchars(initials_from_id($log['user_id'])) ?>
              </a>
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                  <a href="/admin/users/<?= urlencode($log['user_id']) ?>" class="text-sm font-medium truncate hover:underline">User <?= htmlspecialchars($log['user_id']) ?></a>
                  <time datetime="<?= $dt->format(DATE_ATOM) ?>" class="text-xs text-gray-400" title="<?= $dt->format('d.m.Y H:i') ?>"><?= htmlspecialchars(relative_time($dt)) ?></time>
                </div>
                <div class="mt-1 text-sm text-gray-300"><?= htmlspecialchars($log['action']) ?></div>
                <div class="mt-1 text-xs text-gray-400">IP · Gerät</div>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <div class="mt-4 text-center">
        <a href="/admin/logs" class="text-xs text-indigo-400 hover:underline">Alle Aktivitäten anzeigen</a>
      </div>
    </div>
  </div>



  <div class="flex flex-col col-span-1 gap-4 bg-slate-50">

    <a href="/admin/settings" class="flex flex-col justify-center p-4 transition border rounded-md hover:shadow-lg bg-white/4">
      <div class="text-sm text-gray-500">Einstellungen</div>
      <div class="text-lg font-semibold">Konfiguration</div>
    </a>

    <?php
    // Musterdaten: letzte 28 Tage + Vergleich zu den 28 Tagen davor
    $days = [];
    $today = new DateTimeImmutable('today');
    $valuesCurrent = [];
    $valuesPrev = [];

    // Erzeuge aktuelle Werte und berechne vorherige Periode als Variation
    for ($i = 27; $i >= 0; $i--) {
      $d = $today->sub(new DateInterval("P{$i}D"));
      $count = random_int(5, 220);
      $days[] = ['date' => $d, 'count' => $count];
      $valuesCurrent[] = $count;

      // Vorperiode: leichte Variation (70% - 130%) des aktuellen Wertes
      $ratio = random_int(70, 130) / 100;
      $valuesPrev[] = (int) max(0, round($count * $ratio));
    }

    // Labels + Werte für Chart.js
    $labels = array_map(fn($d) => $d['date']->format('d.m'), $days);

    $labelsJson = json_encode($labels, JSON_UNESCAPED_UNICODE);
    $valuesCurrentJson = json_encode($valuesCurrent);
    $valuesPrevJson = json_encode($valuesPrev);

    // Musterliste der aufgerufenen Seiten (absteigend)
    $pages = [
      '/' => 1240,
      '/blog' => 860,
      '/products' => 420,
      '/kontakt' => 310,
      '/admin/login' => 95,
      '/about' => 74,
    ];
    arsort($pages);
    ?>

    <div class="p-4 transition border bg-slate-50 border-slate-200 hover:shadow-lg">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500">Statistiken</div>
          <div class="text-lg font-semibold">Letzte 28 Tage (vs. vorherige 28 Tage)</div>
        </div>
        <div class="text-xs text-gray-300"><?= count($days) ?> Tage</div>
      </div>

      <?php
      $daily = $valuesCurrent[count($valuesCurrent) - 1] ?? 0;
      $avgCurrent = (int) round(array_sum($valuesCurrent) / max(1, count($valuesCurrent)));
      $avgPrev = (int) round(array_sum($valuesPrev) / max(1, count($valuesPrev)));

      $diff = $avgCurrent - $avgPrev;
      $percent = $avgPrev > 0 ? round(($diff / $avgPrev) * 100) : null;

      if ($diff > 0) {
        $arrow = '▲';
        $color = 'text-green-600';
        $label = ($percent === null ? '' : '+' . $percent . '%');
      } elseif ($diff < 0) {
        $arrow = '▼';
        $color = 'text-red-600';
        $label = ($percent === null ? '' : $percent . '%');
      } else {
        $arrow = '';
        $color = 'text-gray-500';
        $label = '—';
      }
      ?>
      <div class="mt-3">
        <div class="h-36">
          <canvas id="activityChart" class="w-full h-full"></canvas>
        </div>

        <div class="flex items-center justify-between mt-3 text-sm">
          <div>
            <div class="text-xs text-gray-400">Heute</div>
            <div class="font-semibold"><?= htmlspecialchars((string)$daily) ?></div>
          </div>

          <div class="text-right">
            <div class="text-xs text-gray-400">Ø / Tag</div>
            <div class="font-semibold <?= $color ?>">
              <?= htmlspecialchars((string)$avgCurrent) ?>
              <span class="ml-2 text-xs text-gray-400"><?= $arrow ?> <?= $label ?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <div class="mb-2 text-sm font-medium">Meistaufgerufene Seiten</div>
        <ul class="space-y-2 text-sm">
          <?php foreach ($pages as $path => $c): ?>
            <li class="flex items-center justify-between">
              <a href="<?= htmlspecialchars($path) ?>" class="truncate hover:underline"><?= htmlspecialchars($path) ?></a>
              <span class="text-xs text-gray-400"><?= htmlspecialchars((string)$c) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="mt-4 text-center">
        <a href="/admin/stats" class="text-xs text-indigo-400 hover:underline">Alle Statistiken ansehen</a>
      </div>
    </div>

    <!-- Chart.js über CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const labels = <?= $labelsJson ?>;
        const valuesCurrent = <?= $valuesCurrentJson ?>;
        const valuesPrev = <?= $valuesPrevJson ?>;

        const canvas = document.getElementById('activityChart');
        const ctx = canvas.getContext('2d');

        // Gradients für Linien/Fills
        const gradCurrent = ctx.createLinearGradient(0, 0, 0, 120);
        gradCurrent.addColorStop(0, 'rgba(99,102,241,0.95)'); // indigo-500
        gradCurrent.addColorStop(1, 'rgba(96,165,250,0.12)'); // softer

        const gradPrev = ctx.createLinearGradient(0, 0, 0, 120);
        gradPrev.addColorStop(0, 'rgba(156,163,175,0.9)'); // gray-400
        gradPrev.addColorStop(1, 'rgba(156,163,175,0.06)');

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [
              {
                label: 'Aktuell (letzte 28 Tage)',
                data: valuesCurrent,
                borderColor: 'rgba(99,102,241,1)',
                backgroundColor: gradCurrent,
                fill: true,
                tension: 0.32,
                pointRadius: 2,
                pointHoverRadius: 4,
                borderWidth: 2
              },
              {
                label: 'Vorperiode (vorherige 28 Tage)',
                data: valuesPrev,
                borderColor: 'rgba(156,163,175,0.9)',
                backgroundColor: gradPrev,
                fill: true,
                tension: 0.32,
                pointRadius: 0,
                pointHoverRadius: 3,
                borderDash: [6, 4],
                borderWidth: 1.5
              }
            ]
          },
          options: {
            plugins: {
              legend: {
                display: true,
                labels: { color: '#94A3B8' } // gray-400
              },
              tooltip: {
                padding: 8,
                callbacks: {
                  label: (ctx) => {
                    return ctx.dataset.label + ': ' + ctx.formattedValue + ' Aufrufe';
                  }
                }
              }
            },
            scales: {
              x: {
                grid: { display: false },
                ticks: { color: '#9CA3AF' } // gray-400
              },
              y: {
                ticks: { color: '#9CA3AF' },
                beginAtZero: true
              }
            },
            maintainAspectRatio: false,
            responsive: true
          }
        });
      });
    </script>

  </div>



</div>


<?php include __DIR__ . '/../../bricks/dashboard/end.php'; ?>