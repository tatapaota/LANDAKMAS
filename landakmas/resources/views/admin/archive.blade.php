@extends('layouts.admin')

@section('title', 'Daftar Arsip | LANDAKMAS')

@section('content')


<h2 class="font-serif text-4xl text-slate-900">Daftar Arsip</h2>


<div class="flex flex-wrap items-center justify-between gap-3 mt-2">
  <p class="text-slate-500">Kelola seluruh arsip</p>
  <button
    id="bulkDeleteBtn"
    type="button"
    onclick="bulkDeleteArchives()"
    disabled
    class="hidden items-center gap-2 bg-rose-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-rose-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
    </svg>
    <span id="bulkDeleteLabel">Hapus Terpilih</span>
  </button>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 mt-8 flex flex-wrap gap-4">
  <div class="relative flex-1 min-w-[220px]">
    <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
    <input class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary text-sm" id="searchInput" placeholder="Cari uraian arsip..." type="text" />
  </div>
  <select class="px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-600 outline-none" id="filterInstansi">
    <!-- diisi otomatis oleh script, termasuk opsi "+ Tambah Instansi Baru" -->
  </select>
  <select class="px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-600 outline-none" id="filterTahun">
    <!-- diisi otomatis oleh script, dimulai dari "Semua Tahun" -->
  </select>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mt-6 overflow-hidden">
  <table class="w-full text-sm" id="archiveTable">
    <thead>
      <tr class="bg-primary text-white text-left">
        <th class="py-4 px-4 font-semibold w-10">
          <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAllArchives(this)" class="w-4 h-4 rounded border-slate-300 align-middle" title="Pilih semua" />
        </th>
        <th class="py-4 px-5 font-semibold">No.</th>
        <th class="py-4 px-3 font-semibold">Cover</th>
        <th class="py-4 px-3 font-semibold">Kode Klasif</th>
        <th class="py-4 px-3 font-semibold">No. Definitif</th>
        <th class="py-4 px-3 font-semibold">Uraian</th>
        <th class="py-4 px-3 font-semibold">Instansi</th>
        <th class="py-4 px-3 font-semibold">Tahun</th>
        <th class="py-4 px-3 font-semibold text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-slate-100" id="archiveTableBody"></tbody>
  </table>
</div>


<div class="hidden fixed inset-0 z-50 bg-slate-400/30 backdrop-blur-sm overflow-y-auto" id="archiveDetailOverlay">
  <div class="max-w-4xl mx-auto px-6 py-10">
    <button class="flex items-center gap-2 bg-primary text-white font-semibold text-lg mb-6 px-4 py-2 rounded-xl shadow-md hover:bg-slate-800 transition" onclick="closeArchiveDetail()">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
      Kembali
    </button>
    <div class="bg-white rounded-3xl shadow-2xl p-8">
      <div class="border-b border-slate-200 pb-6 mb-6"></div>
      <div class="grid sm:grid-cols-2 gap-6">
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">Kode Klasif</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5" id="detailKode"></p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">Tahun</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5" id="detailTahun"></p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">No. Arsip</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5" id="detailNo"></p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">Instansi</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5" id="detailInstansi"></p>
          </div>
        </div>
      </div>
      <div class="border-b border-slate-200 my-8"></div>
      <h3 class="font-serif text-xl text-slate-900 mb-4">Uraian Arsip</h3>
      <div class="bg-slate-50 rounded-xl p-5 text-slate-600 leading-7" id="detailUraian"></div>
      <div id="detailMediaSection">
        <div class="border-b border-slate-200 my-8"></div>
        <h3 class="font-serif text-xl text-slate-900 mb-4">Media</h3>
        <div class="grid sm:grid-cols-3 gap-4" id="detailMediaList"></div>
      </div>
    </div>
  </div>
</div>


<div class="hidden fixed inset-0 z-50 bg-slate-400/30 backdrop-blur-sm overflow-y-auto" id="archiveEditOverlay">
  <div class="max-w-2xl mx-auto px-6 py-10">
    <button class="flex items-center gap-2 bg-primary text-white font-semibold text-lg mb-6 px-4 py-2 rounded-xl shadow-md hover:bg-slate-800 transition" onclick="closeEditArchive()" type="button">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
      Kembali
    </button>
    <form class="bg-white rounded-3xl shadow-2xl p-8" id="editForm" onsubmit="saveEditArchive(event)">
      <h3 class="font-serif text-2xl text-slate-900 mb-6">Edit Arsip</h3>
      <input id="editIdx" type="hidden" />
      <div class="grid sm:grid-cols-2 gap-5">
        <div>
          <label class="text-sm text-slate-500 mb-1 block">Kode Klasif</label>
          <input class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary text-sm" id="editKode" required="" type="text" />
        </div>
        <div>
          <label class="text-sm text-slate-500 mb-1 block">No. Definitif</label>
          <input class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary text-sm" id="editNoDefinitif" type="text" />
        </div>
        <div>
          <label class="text-sm text-slate-500 mb-1 block">Tahun</label>
          <select class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary text-sm" id="editTahun" required=""></select>
        </div>
        <div class="sm:col-span-2">
          <label class="text-sm text-slate-500 mb-1 block">Instansi</label>
          <select class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary text-sm" id="editInstansi" required=""></select>
        </div>
        <div class="sm:col-span-2">
          <label class="text-sm text-slate-500 mb-1 block">Uraian Lengkap</label>
          <textarea class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary text-sm" id="editUraianLengkap" rows="4"></textarea>
        </div>
        <div class="sm:col-span-2">
          <label class="text-sm text-slate-500 mb-1 block">Uraian Singkat</label>
          <input class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 outline-none cursor-not-allowed" id="editUraian" readonly type="text" />
          <p class="text-slate-400 text-xs mt-1">Otomatis diambil dari Uraian Lengkap, tidak perlu diisi manual.</p>
        </div>
        <div class="sm:col-span-2">
          <label class="text-sm text-slate-500 mb-1 block">Media (opsional, boleh lebih dari satu file)</label>
          <label class="block border-2 border-dashed border-slate-300 rounded-xl py-6 text-center cursor-pointer hover:border-secondary/50 hover:bg-slate-50/50 transition" for="editFieldFile">
            <input accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" class="hidden" id="editFieldFile" multiple="" type="file" />
            <span class="text-secondary text-sm font-semibold">Klik untuk tambah file</span>
            <span class="text-slate-400 text-xs block mt-1">PDF, Word, Excel, PNG, JPEG, JPG</span>
          </label>
          <div class="grid sm:grid-cols-2 gap-3 mt-4" id="editMediaPreviewList"></div>
        </div>
      </div>
      <div class="flex justify-end gap-3 mt-8">
        <button class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition" onclick="closeEditArchive()" type="button">
          Batal
        </button>
        <button class="px-5 py-2.5 rounded-xl bg-secondary text-white font-semibold hover:bg-blue-700 transition" type="submit">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>


@php
// Susun ulang data dari model Arsip (kolom database) ke bentuk yang
// dipakai JS di halaman ini (kode, noDefinitif, uraianLengkap, dst),
// termasuk mengubah path file media tersimpan jadi URL yang bisa
// dibuka langsung dari browser.
$imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$arsipsJs = $arsips->map(function ($item) use ($imageExtensions) {
$media = collect($item->media ?? [])->map(function ($path) use ($imageExtensions) {
$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
return [
'name' => basename($path),
'type' => $ext,
'isImage' => in_array($ext, $imageExtensions),
'dataUrl' => asset('storage/' . $path),
'path' => $path,
];
})->values();

return [
'id' => $item->id,
'kode' => $item->kode_klasifikasi ?: '-',
'noDefinitif' => $item->nomor_arsip,
'uraian' => $item->uraian ?: '-',
'uraianLengkap' => $item->uraian_lengkap ?: $item->uraian,
'instansi' => $item->instansi,
'tahun' => $item->tahun,
'media' => $media,
];
})->values();
@endphp

<button
  id="scrollTopBtn"
  type="button"
  title="Kembali ke atas"
  aria-label="Kembali ke atas"
class="fixed bottom-8 right-8 z-40 bg-secondary text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-blue-700 transition-all duration-300 opacity-0 pointer-events-none translate-y-3">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
  </svg>
</button>


<script>
  // Data arsip diambil langsung dari database (lewat controller
  // ArchiveController@index -> $arsips), bukan lagi data dummy hardcoded
  // atau localStorage. Setiap item menyimpan "id" (primary key asli di
  // tabel arsips) supaya tombol Edit/Hapus bisa memanggil endpoint
  // backend yang benar.
  const archives = @json($arsipsJs);
  archives.forEach((a, i) => (a.no = i + 1));

  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
  const ARSIP_BASE_URL = "{{ url('/admin/arsip') }}";

  // id arsip yang sedang dicentang, dipakai untuk "Hapus Terpilih". Pakai
  // Set supaya centang tetap kebawa walau tabel dirender ulang gara-gara
  // pencarian/filter (id yang sama, baris beda posisi).
  const selectedArchiveIds = new Set();

  // ----- daftar instansi, disinkronkan lewat localStorage supaya sama
  // dengan yang dipakai di form Tambah Arsip, dan otomatis melengkapi diri
  // dengan instansi apapun yang sudah kepakai di data arsip (termasuk yang
  // ditambahkan langsung lewat Edit Arsip) supaya tidak pernah ada instansi
  // "hilang" dari pilihan dropdown. -----
  const INSTANSI_STORAGE_KEY = "ardarika_institusi";

  function loadInstitutionList() {
    let list;
    try {
      const saved = JSON.parse(localStorage.getItem(INSTANSI_STORAGE_KEY) || "null");
      list = Array.isArray(saved) && saved.length ? saved : ["Dinas Pertahanan", "Dinas Perizinan", "Dinas Kesehatan"];
    } catch (e) {
      list = ["Dinas Pertahanan", "Dinas Perizinan", "Dinas Kesehatan"];
    }

    archives.forEach((a) => {
      if (a.instansi && a.instansi !== "-" && !list.includes(a.instansi)) {
        list.push(a.instansi);
      }
    });

    return list;
  }

  function saveInstitutionList() {
    localStorage.setItem(INSTANSI_STORAGE_KEY, JSON.stringify(institutionList));
  }

  let institutionList = loadInstitutionList();
  saveInstitutionList();

  const ADD_INSTANSI_VALUE = "__tambah_instansi__";

  // ===========================
  //   RENTANG TAHUN (dinamis)
  // ===========================
  // Sebelumnya rentang tahun di-hardcode 1985–2026, padahal banyak arsip
  // sungguhan bertahun jauh lebih lama (mis. 1967, 1973, 1979 — terlihat
  // di Daftar Arsip). Akibatnya tahun-tahun itu tidak ada sebagai opsi di
  // dropdown Tahun, sehingga saat Edit Arsip dibuka, dropdown tampak
  // kosong walau datanya sebenarnya ada. Sekarang rentangnya dihitung
  // dari data arsip yang sungguhan ada, dengan batas bawah wajar 1945
  // (awal kemerdekaan) dan batas atas tahun berjalan + 1, supaya selalu
  // mencakup tahun berapa pun yang benar-benar tersimpan di database.
  const archiveYearNumbers = archives
    .map((a) => parseInt(a.tahun, 10))
    .filter((y) => !isNaN(y) && y > 0);
  const currentYear = new Date().getFullYear();
  const startYear = Math.min(1945, ...(archiveYearNumbers.length ? archiveYearNumbers : [1945]));
  const endYear = Math.max(currentYear + 1, ...(archiveYearNumbers.length ? archiveYearNumbers : [currentYear + 1]));

  function renderInstansiOptions() {
    const select = document.getElementById("filterInstansi");
    const current = select.value;

    select.innerHTML = `
          <option value="">Instansi</option>
          ${institutionList
            .map((nama) => `<option value="${nama}">${nama}</option>`)
            .join("")}
          <option value="${ADD_INSTANSI_VALUE}">+ Tambah Instansi Baru</option>
        `;

    if (institutionList.includes(current)) select.value = current;
  }

  function renderTahunOptions() {
    const select = document.getElementById("filterTahun");
    const current = select.value;

    // Rentang tahun dihitung dinamis (lihat blok RENTANG TAHUN di atas),
    // bukan lagi hardcode 1985–2026, supaya admin bisa memfilter ke tahun
    // manapun yang benar-benar ada di database, termasuk arsip lama.
    const years = [];
    for (let y = endYear; y >= startYear; y--) years.push(y);

    select.innerHTML = `
          <option value="">Tahun</option>
          ${years.map((y) => `<option value="${y}">${y}</option>`).join("")}
        `;

    if (years.map(String).includes(current)) select.value = current;
  }

  document
    .getElementById("filterInstansi")
    .addEventListener("change", (e) => {
      if (e.target.value === ADD_INSTANSI_VALUE) {
        const nama = prompt("Nama instansi baru:");
        if (nama && nama.trim() && !institutionList.includes(nama.trim())) {
          institutionList.push(nama.trim());
          saveInstitutionList();
          renderInstansiOptions();
          document.getElementById("filterInstansi").value = nama.trim();
        } else {
          e.target.value = "";
        }
      }
      applyFilters();
    });

  document
    .getElementById("filterTahun")
    .addEventListener("change", applyFilters);

  document
    .getElementById("searchInput")
    .addEventListener("input", applyFilters);

  function applyFilters() {
    const instansi = document.getElementById("filterInstansi").value;
    const tahun = document.getElementById("filterTahun").value;
    const keyword = document
      .getElementById("searchInput")
      .value.trim()
      .toLowerCase();

    const filtered = archives.filter((item) => {
      const matchInstansi = !instansi || item.instansi === instansi;
      const matchTahun = !tahun || String(item.tahun) === tahun;
      const matchKeyword = !keyword || item.uraian.toLowerCase().includes(keyword);
      return matchInstansi && matchTahun && matchKeyword;
    });

    renderArchiveTable(filtered);
  }

  // ===========================
  //   URUTAN ARSIP: No. Definitif lalu Tahun
  // ===========================
  // Arsip tidak boleh tampil dengan urutan sembarangan (urutan input) —
  // harus selalu diurutkan berdasarkan No. Definitif (dari yang paling
  // kecil ke yang paling besar), lalu Tahun sebagai tie-breaker kalau ada
  // No. Definitif yang sama.
  function parseTahunAngka(tahun) {
    const n = parseInt(String(tahun || "").match(/\d+/)?.[0] ?? "", 10);
    return isNaN(n) ? Number.MAX_SAFE_INTEGER : n;
  }

  function parseNoDefinitif(no) {
    const match = String(no || "").match(/\d+/);
    return match ? parseInt(match[0], 10) : Number.MAX_SAFE_INTEGER;
  }

  function sortArchives(list) {
    return [...list].sort((a, b) => {
      const noDiff = parseNoDefinitif(a.noDefinitif) - parseNoDefinitif(b.noDefinitif);
      if (noDiff !== 0) return noDiff;
      return parseTahunAngka(a.tahun) - parseTahunAngka(b.tahun);
    });
  }

  function renderCoverCell(item) {
    const cover = (item.media || []).find((m) => m.isImage && m.dataUrl);
    if (cover) {
      return `<img src="${cover.dataUrl}" class="w-12 h-12 rounded-lg object-cover border border-slate-200" alt="Cover ${item.uraian}" onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('div'), {className:'w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-[10px]', innerText:'Gagal muat'}));" />`;
    }
    if ((item.media || []).length > 0) {
      return `
        <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
          </svg>
        </div>`;
    }
    return `<div class="w-12 h-12 rounded-lg bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center text-slate-300 text-xs">–</div>`;
  }

  function renderArchiveTable(data = archives) {
    const body = document.getElementById("archiveTableBody");

    // Selalu diurutkan berdasarkan Kode Klasifikasi + No. Definitif,
    // apapun urutan input/filter/pencarian sebelumnya.
    data = sortArchives(data);

    if (data.length === 0) {
      body.innerHTML = `
            <tr>
              <td colspan="9" class="py-8 px-5 text-center text-slate-400">
                Tidak ada arsip yang ditemukan.
              </td>
            </tr>
          `;
      window.currentTableData = data;
      return;
    }

    body.innerHTML = data
      .map(
        (item, idx) => `
              <tr class="hover:bg-slate-50 transition align-middle">
                <td class="py-4 px-4 align-middle">
                  <input type="checkbox" class="w-4 h-4 rounded border-slate-300 archive-row-checkbox" data-id="${item.id}" onclick="toggleSelectOneArchive(this)" ${selectedArchiveIds.has(item.id) ? "checked" : ""} />
                </td>
                <td class="py-4 px-5 align-middle text-slate-700 font-semibold text-center">${idx + 1}</td>
                <td class="py-4 px-3 align-middle">${renderCoverCell(item)}</td>
                <td class="py-4 px-3 align-middle">
                  <span class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-amber-200 text-amber-900 font-semibold whitespace-nowrap">${item.kode}</span>
                </td>
                <td class="py-4 px-3 align-middle text-slate-600 whitespace-nowrap">${item.noDefinitif || "-"}</td>
                <td class="py-4 px-3 align-middle text-slate-600 max-w-xs line-clamp-2">${item.uraian}</td>
                <td class="py-4 px-3 align-middle text-slate-700 font-medium">${item.instansi}</td>
                <td class="py-4 px-3 align-middle text-slate-600">${item.tahun}</td>
                <td class="py-4 px-3 align-middle">
                  <div class="flex items-center justify-center gap-2">
                    <button title="Detail" onclick="openArchiveDetail(${idx})" class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center hover:bg-slate-700 transition">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                      </svg>
                    </button>
                    <button title="Edit" onclick="openEditArchive(${idx})" class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center hover:bg-slate-700 transition">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                      </svg>
                    </button>
                    <button title="Hapus" onclick="deleteArchive(${idx})" class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center hover:bg-rose-600 transition">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            `,
      )
      .join("");

    // simpan referensi data yang sedang ditampilkan, dipakai saat buka detail/edit/hapus
    window.currentTableData = data;
    syncSelectAllCheckboxState();
  }

  // ===========================
  //   CENTANG SEMUA / SATUAN + HAPUS BORONGAN
  // ===========================
  // Centangan disimpan lewat "id" arsip asli (bukan index baris), jadi
  // tetap benar walau tabel dirender ulang karena filter/pencarian.

  function updateBulkDeleteButton() {
    const btn = document.getElementById("bulkDeleteBtn");
    const label = document.getElementById("bulkDeleteLabel");
    const jumlah = selectedArchiveIds.size;

    if (jumlah > 0) {
      btn.classList.remove("hidden");
      btn.classList.add("inline-flex");
      btn.disabled = false;
      label.textContent = `Hapus Terpilih (${jumlah})`;
    } else {
      btn.classList.add("hidden");
      btn.classList.remove("inline-flex");
      btn.disabled = true;
      label.textContent = "Hapus Terpilih";
    }
  }

  // Checkbox header "pilih semua" cuma mencentang/melepas baris yang
  // sedang tampil (hasil filter/pencarian saat ini), bukan seluruh arsip
  // di database — supaya perilakunya sesuai apa yang admin lihat di layar.
  function syncSelectAllCheckboxState() {
    const selectAll = document.getElementById("selectAllCheckbox");
    const visibleIds = (window.currentTableData || []).map((item) => item.id);

    if (visibleIds.length === 0) {
      selectAll.checked = false;
      selectAll.indeterminate = false;
      return;
    }

    const jumlahTercentang = visibleIds.filter((id) => selectedArchiveIds.has(id)).length;
    selectAll.checked = jumlahTercentang === visibleIds.length;
    selectAll.indeterminate = jumlahTercentang > 0 && jumlahTercentang < visibleIds.length;
  }

  function toggleSelectAllArchives(checkbox) {
    const visibleIds = (window.currentTableData || []).map((item) => item.id);

    if (checkbox.checked) {
      visibleIds.forEach((id) => selectedArchiveIds.add(id));
    } else {
      visibleIds.forEach((id) => selectedArchiveIds.delete(id));
    }

    document.querySelectorAll(".archive-row-checkbox").forEach((cb) => {
      cb.checked = checkbox.checked;
    });

    updateBulkDeleteButton();
  }

  function toggleSelectOneArchive(checkbox) {
    const id = Number(checkbox.dataset.id);

    if (checkbox.checked) {
      selectedArchiveIds.add(id);
    } else {
      selectedArchiveIds.delete(id);
    }

    syncSelectAllCheckboxState();
    updateBulkDeleteButton();
  }

  async function bulkDeleteArchives() {
    const ids = Array.from(selectedArchiveIds);
    if (ids.length === 0) return;

    const konfirmasi = confirm(
      `Yakin ingin menghapus ${ids.length} arsip yang dipilih? Tindakan ini tidak bisa dibatalkan.`,
    );
    if (!konfirmasi) return;

    const btn = document.getElementById("bulkDeleteBtn");
    btn.disabled = true;

    try {
      const res = await fetch(ARSIP_BASE_URL, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": CSRF_TOKEN,
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ ids }),
      });

      if (!res.ok) throw new Error("Gagal menghapus arsip terpilih.");

      ids.forEach((id) => {
        const realIndex = archives.findIndex((a) => a.id === id);
        if (realIndex > -1) archives.splice(realIndex, 1);
      });
      archives.forEach((a, i) => (a.no = i + 1));

      selectedArchiveIds.clear();
      applyFilters();
      updateBulkDeleteButton();
    } catch (e) {
      console.error(e);
      alert("Gagal menghapus arsip terpilih dari database. Coba lagi.");
      btn.disabled = false;
    }
  }

  // Membuka file (dataURL) di tab baru lewat Blob URL, bukan lewat data:
  // URL secara langsung. Browser modern memblokir navigasi ke data: URL
  // yang diklik lewat <a target="_blank"> — inilah sebab file non-gambar
  // (docx, xlsx, pdf, dll) terasa "tidak bisa dipencet". Blob URL tidak
  // diblokir sehingga semua jenis file yang sudah diupload bisa dibuka.
  function openMediaFile(dataUrl, fallbackType) {
    if (!dataUrl) return;

    // File asli yang sudah tersimpan di server (path storage biasa,
    // misal /storage/arsip-media/xxx.jpg) tinggal dibuka langsung lewat
    // URL-nya. Cuma file yang baru dipilih di form (masih berupa data:
    // URI base64 hasil FileReader, belum ter-upload) yang perlu diubah
    // ke Blob URL dulu supaya browser mau membukanya di tab baru.
    if (!dataUrl.startsWith("data:")) {
      window.open(dataUrl, "_blank");
      return;
    }

    try {
      const [meta, base64] = dataUrl.split(",");
      const mime = (meta.match(/:(.*?);/) || [])[1] || fallbackType || "application/octet-stream";
      const bin = atob(base64);
      const bytes = new Uint8Array(bin.length);
      for (let i = 0; i < bin.length; i++) bytes[i] = bin.charCodeAt(i);
      const blob = new Blob([bytes], {
        type: mime
      });
      const blobUrl = URL.createObjectURL(blob);
      window.open(blobUrl, "_blank");
      setTimeout(() => URL.revokeObjectURL(blobUrl), 60000);
    } catch (e) {
      console.error("Gagal membuka file", e);
      alert("Gagal membuka file ini.");
    }
  }

  window.currentDetailMedia = [];

  function openArchiveDetail(idx) {
    const item = window.currentTableData[idx];
    document.getElementById("detailKode").textContent = item.kode;
    document.getElementById("detailTahun").textContent = item.tahun;
    document.getElementById("detailNo").textContent = item.noDefinitif || "-";
    document.getElementById("detailInstansi").textContent = item.instansi;
    document.getElementById("detailUraian").textContent =
      item.uraianLengkap || item.uraian;

    const mediaSection = document.getElementById("detailMediaSection");
    const media = item.media || [];
    window.currentDetailMedia = media;
    if (media.length) {
      document.getElementById("detailMediaList").innerHTML = media
        .map((m, mIdx) => {
          const thumb =
            m.isImage && m.dataUrl ?
            `<img src="${m.dataUrl}" class="w-12 h-12 rounded-lg object-cover shrink-0" />` :
            `<div class="w-12 h-12 rounded-lg bg-slate-200 flex items-center justify-center shrink-0 text-slate-500">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                   </svg>
                 </div>`;

          // Media dengan dataUrl (file sungguhan) bisa dipencet untuk dibuka
          // di tab baru (lewat Blob URL, lihat openMediaFile). Data arsip
          // lama yang belum punya file asli tetap ditampilkan tapi tidak
          // bisa dipencet.
          if (m.dataUrl) {
            return `
              <button type="button" onclick="openMediaFile(window.currentDetailMedia[${mIdx}].dataUrl, window.currentDetailMedia[${mIdx}].type)" class="border border-slate-200 rounded-xl p-3 flex items-center gap-3 bg-slate-50 hover:bg-slate-100 hover:border-secondary/40 transition text-left w-full" title="Klik untuk melihat file">
                ${thumb}
                <p class="text-sm font-medium text-secondary truncate">${m.name}</p>
              </button>
            `;
          }

          return `
            <div class="border border-slate-200 rounded-xl p-3 flex items-center gap-3 bg-slate-50">
              ${thumb}
              <p class="text-sm font-medium text-slate-700 truncate">${m.name}</p>
            </div>
          `;
        })
        .join("");
      mediaSection.classList.remove("hidden");
    } else {
      mediaSection.classList.add("hidden");
    }

    const overlay = document.getElementById("archiveDetailOverlay");
    overlay.classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
    window.scrollTo({
      top: 0,
      behavior: "instant"
    });
  }

  function closeArchiveDetail() {
    document.getElementById("archiveDetailOverlay").classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
  }

  // ===========================
  //   EDIT ARSIP
  // ===========================

  function fillEditYearOptions(selected) {
    const select = document.getElementById("editTahun");
    const years = [];
    for (let y = endYear; y >= startYear; y--) years.push(y);
    select.innerHTML = years
      .map((y) => `<option value="${y}">${y}</option>`)
      .join("");
    select.value = selected;
  }

  function fillEditInstansiOptions(selected) {
    const select = document.getElementById("editInstansi");
    // Jaga-jaga: kalau instansi arsip ini entah bagaimana belum ada di
    // institutionList, tambahkan dulu supaya dropdown Edit tidak pernah
    // muncul kosong/tidak terpilih.
    if (selected && selected !== "-" && !institutionList.includes(selected)) {
      institutionList.push(selected);
      saveInstitutionList();
    }
    select.innerHTML =
      institutionList
      .map((nama) => `<option value="${nama}">${nama}</option>`)
      .join("") +
      `<option value="${ADD_INSTANSI_VALUE}">+ Tambah Instansi Baru</option>`;
    select.value = selected;
  }

  document
    .getElementById("editInstansi")
    .addEventListener("change", (e) => {
      if (e.target.value === ADD_INSTANSI_VALUE) {
        const nama = prompt("Nama instansi baru:");
        if (nama && nama.trim() && !institutionList.includes(nama.trim())) {
          institutionList.push(nama.trim());
          saveInstitutionList();
          fillEditInstansiOptions(nama.trim());
          renderInstansiOptions();
        } else {
          e.target.value = institutionList[0] || "";
        }
      }
    });

  // ===========================
  //   URAIAN SINGKAT OTOMATIS
  // ===========================
  // Uraian Singkat tidak lagi diisi manual: nilainya selalu diturunkan dari
  // Uraian Lengkap (ambil ±120 karakter pertama, dipotong di batas kata).
  function deriveUraianSingkat(teksLengkap) {
    const teks = (teksLengkap || "").trim();
    if (!teks) return "";

    const maxLen = 120;
    if (teks.length <= maxLen) return teks;

    let potongan = teks.slice(0, maxLen);
    const batasSpasi = potongan.lastIndexOf(" ");
    if (batasSpasi > 0) potongan = potongan.slice(0, batasSpasi);

    return potongan.trim() + "...";
  }

  function updateEditUraianSingkat() {
    const lengkap = document.getElementById("editUraianLengkap").value;
    document.getElementById("editUraian").value = deriveUraianSingkat(lengkap);
  }

  document
    .getElementById("editUraianLengkap")
    .addEventListener("input", updateEditUraianSingkat);

  // ===========================
  //   UPLOAD MEDIA (form Edit Arsip)
  // ===========================
  let editSelectedMedia = []; // { id, name, type, isImage, dataUrl }
  let editMediaIdCounter = 0;

  function renderEditMediaPreview() {
    const wrap = document.getElementById("editMediaPreviewList");
    wrap.innerHTML = editSelectedMedia
      .map((m) => {
        const thumb =
          m.isImage && m.dataUrl ?
          `<img src="${m.dataUrl}" class="w-10 h-10 rounded-lg object-cover shrink-0" />` :
          `<div class="w-10 h-10 rounded-lg bg-slate-200 flex items-center justify-center shrink-0 text-slate-500">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                 </svg>
               </div>`;

        // Kalau file ini punya dataUrl (file baru diupload, atau data lama
        // yang sudah punya URL asli), namanya bisa dipencet untuk dibuka
        // di tab baru lewat Blob URL (lihat openEditMediaFile). Kalau belum
        // ada dataUrl (arsip lama tanpa file sungguhan), tampilkan sebagai
        // teks biasa saja.
        const namaFile = m.dataUrl ?
          `<button type="button" onclick="openEditMediaFile(${m.id})" class="text-xs font-medium text-secondary hover:underline truncate flex-1 text-left" title="Klik untuk melihat file">${m.name}</button>` :
          `<p class="text-xs font-medium text-slate-700 truncate flex-1">${m.name}</p>`;

        return `
          <div class="relative flex items-center gap-3 border border-slate-200 rounded-xl p-3 bg-slate-50">
            ${
              m.dataUrl
                ? `<button type="button" onclick="openEditMediaFile(${m.id})" class="shrink-0">${thumb}</button>`
                : thumb
            }
            ${namaFile}
            <button type="button" onclick="removeEditMedia(${m.id})" class="text-slate-400 hover:text-rose-500 shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        `;
      })
      .join("");
  }

  function openEditMediaFile(id) {
    const m = editSelectedMedia.find((x) => x.id === id);
    if (m) openMediaFile(m.dataUrl, m.type);
  }

  function removeEditMedia(id) {
    editSelectedMedia = editSelectedMedia.filter((m) => m.id !== id);
    renderEditMediaPreview();
  }

  document.getElementById("editFieldFile").addEventListener("change", (e) => {
    Array.from(e.target.files).forEach((file) => {
      const id = ++editMediaIdCounter;
      const isImage = file.type.startsWith("image/");

      // Semua tipe file dibaca sebagai data URL (bukan cuma gambar) supaya
      // file yang baru diupload (gambar maupun dokumen) tetap bisa
      // dipencet/dibuka lagi lewat pratinjau di bawah.
      const reader = new FileReader();
      reader.onload = (ev) => {
        editSelectedMedia.push({
          id,
          name: file.name,
          type: file.type,
          isImage,
          dataUrl: ev.target.result,
          file, // file asli, dikirim ke server saat "Simpan Perubahan"
        });
        renderEditMediaPreview();
      };
      reader.readAsDataURL(file);
    });
    e.target.value = "";
  });

  function openEditArchive(idx) {
    const item = window.currentTableData[idx];

    document.getElementById("editIdx").value = item.id;
    document.getElementById("editKode").value = item.kode;
    document.getElementById("editNoDefinitif").value = item.noDefinitif || "";
    document.getElementById("editUraianLengkap").value =
      item.uraianLengkap || item.uraian || "";
    updateEditUraianSingkat();

    // Media yang sudah ada di server dibawa lagi lewat "path" (dipakai
    // saat submit lewat existing_media[] supaya tidak hilang kalau tidak
    // dihapus), file yang baru dipilih lewat form dibawa lewat "file".
    editSelectedMedia = (item.media || []).map((m) => ({
      id: ++editMediaIdCounter,
      ...m,
    }));
    renderEditMediaPreview();

    fillEditYearOptions(item.tahun);
    fillEditInstansiOptions(item.instansi);

    const overlay = document.getElementById("archiveEditOverlay");
    overlay.classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
    window.scrollTo({
      top: 0,
      behavior: "instant"
    });
  }

  function closeEditArchive() {
    document.getElementById("archiveEditOverlay").classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
  }

  async function saveEditArchive(event) {
    event.preventDefault();

    const id = document.getElementById("editIdx").value;
    const item = archives.find((a) => a.id == id);
    if (!id || !item) {
      closeEditArchive();
      return;
    }

    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalLabel = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = "Menyimpan...";

    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("_token", CSRF_TOKEN);
    formData.append("kode_klasifikasi", document.getElementById("editKode").value.trim());
    formData.append("nomor_arsip", document.getElementById("editNoDefinitif").value.trim());
    formData.append("tahun", document.getElementById("editTahun").value);
    formData.append("instansi", document.getElementById("editInstansi").value);
    formData.append("uraian_lengkap", document.getElementById("editUraianLengkap").value.trim());

    editSelectedMedia.forEach((m) => {
      if (m.file) {
        formData.append("media[]", m.file);
      } else if (m.path) {
        formData.append("existing_media[]", m.path);
      }
    });

    try {
      const res = await fetch(`${ARSIP_BASE_URL}/${id}`, {
        method: "POST", // di-spoof jadi PUT lewat field _method di atas
        headers: {
          "X-CSRF-TOKEN": CSRF_TOKEN
        },
        body: formData,
      });

      if (!res.ok) throw new Error("Gagal menyimpan perubahan.");

      // Cara paling aman supaya tabel benar-benar sinkron dengan database
      // (termasuk uraian singkat otomatis & path media baru) adalah muat
      // ulang halaman ini dari server.
      window.location.reload();
    } catch (e) {
      console.error(e);
      alert("Gagal menyimpan perubahan. Coba lagi.");
      submitBtn.disabled = false;
      submitBtn.textContent = originalLabel;
    }
  }

  function highlightUpdatedRow(item) {
    const rowIndex = window.currentTableData.indexOf(item);
    if (rowIndex === -1) return;

    const row = document.querySelectorAll("#archiveTableBody tr")[rowIndex];
    if (!row) return;

    row.scrollIntoView({
      behavior: "smooth",
      block: "center"
    });
    row.classList.add("bg-emerald-50", "ring-2", "ring-emerald-300");
    setTimeout(() => {
      row.classList.remove("bg-emerald-50", "ring-2", "ring-emerald-300");
    }, 1600);
  }

  // ===========================
  //   HAPUS ARSIP
  // ===========================

  async function deleteArchive(idx) {
    const item = window.currentTableData[idx];
    if (!item) return;

    const konfirmasi = confirm(
      `Yakin ingin menghapus arsip "${item.uraian}"?`,
    );
    if (!konfirmasi) return;

    try {
      const res = await fetch(`${ARSIP_BASE_URL}/${item.id}`, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": CSRF_TOKEN
        },
      });

      if (!res.ok) throw new Error("Gagal menghapus arsip.");

      const realIndex = archives.findIndex((a) => a.id === item.id);
      if (realIndex > -1) {
        archives.splice(realIndex, 1);
        archives.forEach((a, i) => (a.no = i + 1));
      }

      applyFilters();
    } catch (e) {
      console.error(e);
      alert("Gagal menghapus arsip dari database. Coba lagi.");
    }
  }

  renderInstansiOptions();
  renderTahunOptions();
  renderArchiveTable();

  // ===========================
  //   TOMBOL "KEMBALI KE ATAS"
  // ===========================
  // Muncul otomatis begitu halaman di-scroll ke bawah, supaya admin bisa
  // langsung lompat balik ke paling atas tanpa scroll manual lagi.
  const scrollTopBtn = document.getElementById("scrollTopBtn");

  function toggleScrollTopBtn() {
    if (window.scrollY > 300) {
      scrollTopBtn.classList.remove("opacity-0", "pointer-events-none", "translate-y-3");
    } else {
      scrollTopBtn.classList.add("opacity-0", "pointer-events-none", "translate-y-3");
    }
  }

  window.addEventListener("scroll", toggleScrollTopBtn);
  toggleScrollTopBtn();

  scrollTopBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
</script>


@endsection