<?php
$currentPage = 'Pages';
include __DIR__ . '/../../bricks/dashboard/base.php';
?>

<div class="grid h-full grid-cols-12 gap-4">
  <div class="col-span-9 p-4">

  <div class="mb-4">
    <div class="flex items-center gap-2">
      <label for="page-search" class="sr-only">Seite suchen</label>
      <input id="page-search" type="search" placeholder="Seite suchen..." class="flex-1 px-3 py-2 bg-white border rounded-lg border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <button type="button" title="Seite hinzufügen" aria-label="Seite hinzufügen" onclick="location.href='/admin/pages/new'" class="inline-flex items-center gap-2 px-3 py-2 ml-2 text-sm font-medium text-white bg-gradient-to-br from-sky-500 to-indigo-600 hover:from-sky-600 hover:to-indigo-700 shadow-md rounded-lg transform hover:-translate-y-0.5 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 5v14M5 12h14"/>
        </svg>
        <span>Seite hinzufügen</span>
      </button>
    </div>
  </div>


  
  <div class="p-4 mb-4 border rounded-lg shadow-sm bg-slate-50 border-slate-200">
    <div class="flex items-start gap-4">
      <img src="/img/pages/home.png" alt="Seiten Vorschaubild" class="flex-shrink-0 object-cover object-top w-1/6 border border-white rounded-md shadow aspect-video">
      <div class="flex-1">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-slate-800">Beispielseite Titel</h3>
            <p class="text-xs text-slate-700"><span class="text-xs opacity-60"><?= app('site.domain'); ?></span>/beispielseite</p>
          </div>
          <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded">Veröffentlicht</span>
        </div>
        <p class="mt-2 text-sm text-slate-600">Kurze Beschreibung der Seite. Ein bis zwei Zeilen, die erklären, worum es auf der Seite geht.</p>
        <div class="flex items-center gap-2 mt-3">
          <a href="/admin/pages/123/edit" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">Bearbeiten</a>
          <a href="/beispielseite" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-slate-700 bg-slate-100 rounded hover:bg-slate-200">Ansehen</a>
          <button type="button" onclick="if(confirm('Seite löschen?')) location.href='/admin/pages/123/delete';" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 rounded hover:bg-red-100">Löschen</button>
          <span class="ml-auto text-xs text-slate-400">Aktualisiert: 12.06.2025</span>
        </div>
      </div>
    </div>
  </div>

  </div>
  <div class="col-span-3 border-l bg-slate-50 border-slate-200">
    <a href="/admin/pages/new" class="inline-block px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">Neue Seite erstellen</a>
  </div>
</div>


<?php include __DIR__ . '/../../bricks/dashboard/end.php'; ?>