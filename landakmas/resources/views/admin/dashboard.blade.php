@extends('layouts.admin')

@section('title', 'Dashboard Admin | LANDAKMAS')

@section('content')


<h2 class="font-serif text-4xl text-slate-900">Dashboard Admin</h2>


<p class="text-slate-500 mt-2">
  Kelola seluruh arsip pengadaan dari semua unit kerja
</p>


<div class="grid md:grid-cols-3 gap-6 mt-8">
  <div class="bg-white rounded-2xl shadow-sm border-l-4 border-primary p-6 flex items-start justify-between">
    <div>
      <p class="text-slate-500 text-sm">Total Arsip</p>
      <h3 class="font-serif text-4xl font-bold text-primary mt-2">{{ $statTotalArsip }}</h3>
    </div>
    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M19.5 21V8.25a2.25 2.25 0 00-.659-1.591l-4.5-4.5A2.25 2.25 0 0012.75 1.5H6A2.25 2.25 0 003.75 3.75v16.5A2.25 2.25 0 006 22.5h11.25A2.25 2.25 0 0019.5 21z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
  <div class="bg-white rounded-2xl shadow-sm border-l-4 border-emerald-500 p-6 flex items-start justify-between">
    <div>
      <p class="text-slate-500 text-sm">Arsip Publik</p>
      <h3 class="font-serif text-4xl font-bold text-emerald-500 mt-2">
        {{ $statArsipPublik }}
      </h3>
    </div>
    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" stroke-linecap="round" stroke-linejoin="round"></path>
      <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
  <div class="bg-white rounded-2xl shadow-sm border-l-4 border-amber-500 p-6 flex items-start justify-between">
    <div>
      <p class="text-slate-500 text-sm">Total Instansi</p>
      <h3 class="font-serif text-4xl font-bold text-amber-500 mt-2">
        {{ $statTotalInstansi }}
      </h3>
    </div>
    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
</div>


<div class="grid md:grid-cols-2 gap-6 mt-6">
  <div class="bg-white rounded-2xl shadow-sm border-l-4 border-primary p-6 flex items-start justify-between">
    <div>
      <p class="text-slate-500 text-sm">Arsip Ditambahkan Bulan Ini</p>
      <h3 class="font-serif text-4xl font-bold text-primary mt-2">{{ $statArsipBulanIni }}</h3>
    </div>
    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M19.5 21V8.25a2.25 2.25 0 00-.659-1.591l-4.5-4.5A2.25 2.25 0 0012.75 1.5H6A2.25 2.25 0 003.75 3.75v16.5A2.25 2.25 0 006 22.5h11.25A2.25 2.25 0 0019.5 21z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
  <div class="bg-white rounded-2xl shadow-sm border-l-4 border-amber-500 p-6">
    <p class="text-slate-500 text-sm">Rentang Tahun Arsip</p>
    <h3 class="font-serif text-4xl font-bold text-amber-500 mt-2">
      {{ $statTahunAwal }} - {{ $statTahunAkhir }}
    </h3>
    <p class="text-slate-400 text-xs mt-2">
      Arsip yang terdatar dalam sistem
    </p>
  </div>
</div>


{{--
    Statistik Pengunjung di dashboard admin memakai sumber data yang
    SAMA PERSIS dengan kartu di Beranda publik (lihat
    Admin\DashboardController::visitorStats() /
    App\Support\VisitorStats::pageVisitSummary()) — pengunjung situs
    sesungguhnya, dihitung per sesi browser unik, dan ikut live
    (auto-update tiap beberapa detik) seperti di Beranda.
--}}
<div class="mt-10">
  @include('partials.visitor_stats_card', array_merge([
      'hariIni' => $hariIni,
      'mingguIni' => $mingguIni,
      'bulanIni' => $bulanIni,
      'tahunIni' => $tahunIni,
      'total' => $total,
      'postTerpopulerLabel' => $postTerpopulerLabel,
      'postTerpopulerCount' => $postTerpopulerCount,
  ], ['live' => true]))
</div>


<div class="grid lg:grid-cols-2 gap-6 mt-10">
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <h3 class="font-serif text-xl text-center text-slate-900">
      Arsip per Tahun
    </h3>
    <div class="border-b border-slate-200 mt-3 mb-5"></div>
    <select class="border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-600 mb-6" id="filterInstansiTahunChart">
      <option value="">Semua Instansi</option>
    </select>
    <canvas height="220" id="chartPerTahun"></canvas>
  </div>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <h3 class="font-serif text-xl text-center text-slate-900">
      Arsip per Instansi
    </h3>
    <div class="border-b border-slate-200 mt-3 mb-5"></div>
    <div class="flex gap-3 mb-6">
      <select class="border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-600" id="filterTahunInstansiChart">
        <option value="">Semua Tahun</option>
      </select>
      <select class="border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-600" id="filterInstansiInstansiChart">
        <option value="">Semua Instansi</option>
      </select>
    </div>
    <canvas height="220" id="chartPerInstansi"></canvas>
  </div>
</div>




<script>
  // Rincian jumlah arsip per (instansi, tahun), diambil langsung dari
  // database lewat DashboardController@index — dipakai untuk menyusun
  // kedua grafik di bawah dan menerapkan filter dropdown-nya.
  const breakdown = @json($breakdownJs);
  const instansiListAll = [...new Set(breakdown.map((b) => b.instansi))].sort();
  const tahunListAll = [...new Set(breakdown.map((b) => b.tahun))].sort(
    (a, b) => Number(a) - Number(b),
  );

  // ----- Isi pilihan dropdown dari data yang sungguhan ada -----
  function fillSelectOptions(selectId, values, placeholderLabel) {
    const select = document.getElementById(selectId);
    select.innerHTML =
      `<option value="">${placeholderLabel}</option>` +
      values.map((v) => `<option value="${v}">${v}</option>`).join("");
  }

  fillSelectOptions("filterInstansiTahunChart", instansiListAll, "Semua Instansi");
  fillSelectOptions("filterTahunInstansiChart", tahunListAll, "Semua Tahun");
  fillSelectOptions("filterInstansiInstansiChart", instansiListAll, "Semua Instansi");

  // ----- Chart: Arsip per Tahun (bar merah) -----
  // Dijumlahkan per tahun, difilter ke satu instansi kalau dropdown
  // "Instansi" di panel ini dipilih (kosong = jumlahkan semua instansi).
  const perTahunChart = new Chart(document.getElementById("chartPerTahun"), {
    type: "bar",
    data: {
      labels: [],
      datasets: [
        {
          data: [],
          backgroundColor: "#ef4444",
          borderRadius: 4,
          maxBarThickness: 46,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0,
          },
          grid: {
            color: "#f1f5f9",
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
    },
  });

  function updatePerTahunChart() {
    const instansi = document.getElementById("filterInstansiTahunChart").value;
    const relevan = breakdown.filter((b) => !instansi || b.instansi === instansi);

    const totalPerTahun = {};
    relevan.forEach((b) => {
      totalPerTahun[b.tahun] = (totalPerTahun[b.tahun] || 0) + b.jumlah;
    });

    const tahunTerpakai = Object.keys(totalPerTahun).sort(
      (a, b) => Number(a) - Number(b),
    );

    perTahunChart.data.labels = tahunTerpakai;
    perTahunChart.data.datasets[0].data = tahunTerpakai.map(
      (t) => totalPerTahun[t],
    );
    perTahunChart.update();
  }

  document
    .getElementById("filterInstansiTahunChart")
    .addEventListener("change", updatePerTahunChart);

  // ----- Chart: Arsip per Instansi (bar biru) -----
  // Dijumlahkan per instansi, difilter ke satu tahun kalau dropdown
  // "Tahun" dipilih, dan/atau dipersempit ke satu instansi kalau dropdown
  // "Instansi" dipilih (kosong = tampilkan semua instansi).
  const perInstansiChart = new Chart(document.getElementById("chartPerInstansi"), {
    type: "bar",
    data: {
      labels: [],
      datasets: [
        {
          data: [],
          backgroundColor: "#60a5fa",
          borderRadius: 4,
          maxBarThickness: 46,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0,
          },
          grid: {
            color: "#f1f5f9",
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
    },
  });

  function updatePerInstansiChart() {
    const tahun = document.getElementById("filterTahunInstansiChart").value;
    const instansi = document.getElementById("filterInstansiInstansiChart").value;

    const relevan = breakdown.filter(
      (b) =>
        (!tahun || b.tahun === tahun) && (!instansi || b.instansi === instansi),
    );

    const totalPerInstansi = {};
    relevan.forEach((b) => {
      totalPerInstansi[b.instansi] = (totalPerInstansi[b.instansi] || 0) + b.jumlah;
    });

    // Diurutkan dari yang paling banyak arsipnya, maksimal 8 instansi
    // teratas supaya grafik tetap enak dibaca.
    const urutan = Object.entries(totalPerInstansi)
      .sort((a, b) => b[1] - a[1])
      .slice(0, 8);

    perInstansiChart.data.labels = urutan.map(([nama]) => nama);
    perInstansiChart.data.datasets[0].data = urutan.map(([, jumlah]) => jumlah);
    perInstansiChart.update();
  }

  document
    .getElementById("filterTahunInstansiChart")
    .addEventListener("change", updatePerInstansiChart);
  document
    .getElementById("filterInstansiInstansiChart")
    .addEventListener("change", updatePerInstansiChart);

  updatePerTahunChart();
  updatePerInstansiChart();
</script>


@endsection