@extends('layouts.admin')

@section('title', 'Permintaan Booking | LANDAKMAS')

@section('content')


<div class="flex items-start justify-between flex-wrap gap-4">
  <div>
    <h2 class="font-serif text-4xl text-slate-900">
      Permintaan Booking
    </h2>
    <p class="text-slate-500 mt-2">
      Riwayat seluruh permintaan booking arsip yang dikirim masyarakat
      lewat formulir "Data Peminjam" di halaman publik.
    </p>
  </div>
  <button class="flex items-center gap-2 bg-secondary text-white font-semibold px-5 py-3 rounded-xl hover:bg-blue-700 transition shrink-0" id="exportBtn" type="button">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
    Export ke Excel
  </button>
</div>


<div class="bg-white rounded-2xl shadow-sm p-6 mt-8 inline-flex items-center gap-4">
  <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
    <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
  <div>
    <p class="text-slate-500 text-sm">Total Permintaan Masuk</p>
    <h3 class="font-serif text-3xl font-bold text-primary" id="totalCount">
      0
    </h3>
  </div>
</div>


<div class="hidden mt-8 bg-white rounded-2xl shadow-sm p-12 text-center" id="emptyState">
  <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mx-auto">
    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
  <h3 class="font-serif text-xl text-slate-800 mt-4">
    Belum ada permintaan booking
  </h3>
  <p class="text-slate-500 mt-1 text-sm">
    Kalau ada masyarakat yang mengirim formulir booking arsip, datanya
    akan otomatis muncul di tabel ini.
  </p>
</div>


<div class="hidden mt-8 bg-white rounded-2xl shadow-sm overflow-hidden overflow-x-auto" id="tableWrapper">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left text-white bg-primary">
        <th class="px-6 py-4 font-semibold">No</th>
        <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
        <th class="px-6 py-4 font-semibold">No. Telepon</th>
        <th class="px-6 py-4 font-semibold">Email</th>
        <th class="px-6 py-4 font-semibold">Alamat</th>
        <th class="px-6 py-4 font-semibold">Arsip yang Dibooking</th>
        <th class="px-6 py-4 font-semibold">Tujuan Permintaan</th>
        <th class="px-6 py-4 font-semibold">Tanggal &amp; Waktu Pengambilan (diatur admin)</th>
        <th class="px-6 py-4 font-semibold">Tanggal &amp; Waktu</th>
        <th class="px-6 py-4 font-semibold">Status</th>
        <th class="px-6 py-4 font-semibold">Status Email</th>
        <th class="px-6 py-4 font-semibold">Aksi</th>
      </tr>
    </thead>
    <tbody id="bookingTableBody"></tbody>
  </table>
</div>




<script>
  // Data booking sekarang datang langsung dari database (tabel
  // booking_requests, disiapkan di BookingController@index), bukan lagi
  // dari localStorage. Bentuknya sudah disamakan di controller dengan
  // format lama (id, nama, ..., arsip: {no, kode, uraian, instansi,
  // tahun}, tanggal, tanggalPengambilan, status, dikembalikanAt) supaya
  // fungsi render & export di bawah tidak perlu diubah banyak.
  let bookingRequestsFromServer = @json($bookingsForJs);

  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
  const BOOKING_BASE_URL = "{{ url('/admin/permintaan-booking') }}";

  function getBookingRequests() {
    return bookingRequestsFromServer;
  }

  function formatArsip(item) {
    if (!item.arsip) return "-";
    const {
      no,
      kode,
      uraian,
      instansi,
      tahun
    } = item.arsip;
    const parts = [];
    if (no) parts.push(`No. ${no}`);
    parts.push(`Kode Klasifikasi: ${kode || "-"}`);
    parts.push(`Instansi: ${instansi || "-"}`);
    parts.push(`Tahun: ${tahun || "-"}`);
    if (uraian) parts.push(`Uraian: ${uraian}`);
    return parts.join(" | ");
  }

  function arsipCellHTML(item) {
    if (!item.arsip) return "-";
    const {
      no,
      kode,
      uraian,
      instansi,
      tahun
    } = item.arsip;

    return `
          <div class="flex flex-col gap-2">
            ${
              no
                ? `<span class="bg-primary text-white px-2.5 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap w-fit">No.${no}</span>`
                : ""
            }
            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs">
              <p><strong class="text-slate-700">Kode Klasifikasi:</strong> <span class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">${
                kode || "-"
              }</span></p>
              <p><strong class="text-slate-700">Instansi:</strong> <span class="text-slate-600">${
                instansi || "-"
              }</span></p>
              <p><strong class="text-slate-700">Tahun:</strong> <span class="text-slate-600">${
                tahun || "-"
              }</span></p>
            </div>
            ${
              uraian
                ? `<div class="text-xs">
                    <strong class="text-slate-700 block mb-0.5">Uraian:</strong>
                    <p class="text-slate-500 leading-relaxed">${uraian}</p>
                  </div>`
                : ""
            }
          </div>
        `;
  }

  // Badge status: "Diproses" (masih dipinjam) atau "Dikembalikan" (sudah
  // balik & arsipnya tersedia lagi di halaman publik).
  function statusBadgeHTML(item) {
    const sudahKembali = item.status === "dikembalikan";
    const colorClasses = sudahKembali
      ? "bg-emerald-50 text-emerald-700"
      : "bg-amber-50 text-amber-700";
    const label = sudahKembali ? "Dikembalikan" : "Diproses";

    return `
          <span class="inline-flex items-center gap-1.5 ${colorClasses} px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap">
            <span class="w-1.5 h-1.5 rounded-full ${
              sudahKembali ? "bg-emerald-500" : "bg-amber-500"
            }"></span>
            ${label}
          </span>
        `;
  }

  // Tombol "Kembalikan Dokumen" hanya muncul selama booking masih
  // berstatus "diproses". Begitu sudah dikembalikan, diganti keterangan
  // tanggal pengembaliannya.
  function aksiCellHTML(item) {
    if (item.status === "dikembalikan") {
      return `<span class="text-xs text-slate-400">Dikembalikan ${formatTanggal(
        item.dikembalikanAt,
      )}</span>`;
    }

    return `
          <button
            type="button"
            class="return-doc-btn flex items-center gap-1.5 bg-emerald-600 text-white text-xs font-semibold px-3.5 py-2 rounded-lg hover:bg-emerald-700 transition whitespace-nowrap"
            data-id="${item.id}"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Kembalikan Dokumen
          </button>
        `;
  }

  // Input tanggal & jam pengambilan final, ditentukan/diubah admin
  // (disimpan lewat PUT ke BookingController@setWaktu begitu admin
  // menekan "Simpan"). Tanggal ini terisi awal dari tanggal yang
  // dipilih user saat booking, tapi tetap bisa digeser admin kalau
  // tanggal itu tidak bisa dipakai (mis. kantor tutup / sudah penuh).
  function waktuPengambilanCellHTML(item) {
    return `
          <div class="flex items-center gap-2">
            <input
              type="date"
              class="tanggal-input border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-slate-700"
              data-id="${item.id}"
              value="${item.tanggalPengambilan || ""}"
            />
            <input
              type="time"
              class="waktu-input border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-slate-700"
              data-id="${item.id}"
              value="${item.waktuPengambilan || ""}"
            />
            <button
              type="button"
              class="simpan-waktu-btn text-xs font-semibold text-secondary border border-secondary/30 bg-blue-50 px-2.5 py-1.5 rounded-lg hover:bg-blue-100 transition whitespace-nowrap"
              data-id="${item.id}"
            >
              Simpan
            </button>
          </div>
        `;
  }

  // Tombol "Kirim ke Email Peminjam": nonaktif kalau waktu pengambilan
  // belum diisi, dan berubah jadi keterangan "Terkirim" begitu email
  // sudah pernah dikirim untuk booking ini.
  function emailCellHTML(item) {
    if (item.emailTerkirimAt) {
      return `
            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.5 12.75l6 6 9-13.5" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              Terkirim ${formatTanggal(item.emailTerkirimAt)}
            </span>
          `;
    }

    const disabled = !item.tanggalPengambilan || !item.waktuPengambilan;

    return `
          <button
            type="button"
            class="kirim-email-btn flex items-center gap-1.5 bg-primary text-white text-xs font-semibold px-3.5 py-2 rounded-lg hover:bg-blue-900 transition whitespace-nowrap disabled:opacity-40 disabled:cursor-not-allowed"
            data-id="${item.id}"
            ${disabled ? "disabled title=\"Tentukan tanggal & waktu pengambilan dulu\"" : ""}
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Kirim ke Email Peminjam
          </button>
        `;
  }

  // Klik "Simpan" tanggal & jam pengambilan -> PUT ke BookingController@setWaktu.
  document
    .getElementById("bookingTableBody")
    .addEventListener("click", async (e) => {
      const btn = e.target.closest(".simpan-waktu-btn");
      if (!btn) return;

      const id = btn.dataset.id;
      const row = btn.closest("tr");
      const tanggalInput = row.querySelector(`.tanggal-input[data-id="${id}"]`);
      const waktuInput = row.querySelector(`.waktu-input[data-id="${id}"]`);
      const tanggal = tanggalInput ? tanggalInput.value : "";
      const waktu = waktuInput ? waktuInput.value : "";

      if (!tanggal || !waktu) {
        alert("Pilih tanggal dan jam pengambilan terlebih dahulu.");
        return;
      }

      btn.disabled = true;
      btn.textContent = "Menyimpan...";

      try {
        const res = await fetch(`${BOOKING_BASE_URL}/${id}/waktu`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": CSRF_TOKEN,
            Accept: "application/json",
          },
          body: JSON.stringify({
            tanggal_pengambilan: tanggal,
            waktu_pengambilan: waktu,
          }),
        });

        if (!res.ok) throw new Error("Gagal menyimpan tanggal/waktu pengambilan.");

        const data = await res.json();

        bookingRequestsFromServer = bookingRequestsFromServer.map((item) =>
          item.id == id
            ? {
                ...item,
                tanggalPengambilan: data.booking.tanggal_pengambilan
                  ? data.booking.tanggal_pengambilan.slice(0, 10)
                  : item.tanggalPengambilan,
                waktuPengambilan: data.booking.waktu_pengambilan,
              }
            : item,
        );

        renderBookingTable();
      } catch (err) {
        alert("Gagal menyimpan tanggal/waktu pengambilan. Coba lagi.");
        btn.disabled = false;
        btn.textContent = "Simpan";
      }
    });

  // Klik "Kirim ke Email Peminjam" -> POST ke BookingController@sendEmail.
  document
    .getElementById("bookingTableBody")
    .addEventListener("click", async (e) => {
      const btn = e.target.closest(".kirim-email-btn");
      if (!btn) return;

      const id = btn.dataset.id;
      const confirmed = confirm(
        "Kirim email jadwal pengambilan arsip ke peminjam ini?",
      );
      if (!confirmed) return;

      btn.disabled = true;
      btn.classList.add("opacity-60", "cursor-not-allowed");
      btn.textContent = "Mengirim...";

      try {
        const res = await fetch(`${BOOKING_BASE_URL}/${id}/kirim-email`, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": CSRF_TOKEN,
            Accept: "application/json",
          },
        });

        const data = await res.json().catch(() => null);

        if (!res.ok) {
          throw new Error(data?.message || "Gagal mengirim email.");
        }

        bookingRequestsFromServer = bookingRequestsFromServer.map((item) =>
          item.id == id
            ? { ...item, emailTerkirimAt: data.booking.email_terkirim_at }
            : item,
        );

        renderBookingTable();
      } catch (err) {
        alert(err.message || "Gagal mengirim email. Coba lagi.");
        btn.disabled = false;
        btn.classList.remove("opacity-60", "cursor-not-allowed");
        btn.textContent = "Kirim ke Email Peminjam";
      }
    });

  // Klik "Kembalikan Dokumen" -> tandai booking dikembalikan + arsip
  // terkait balik "tersedia" lagi, lewat PUT ke BookingController@returnDocument.
  document
    .getElementById("bookingTableBody")
    .addEventListener("click", async (e) => {
      const btn = e.target.closest(".return-doc-btn");
      if (!btn) return;

      const id = btn.dataset.id;
      const confirmed = confirm(
        "Tandai dokumen ini sudah dikembalikan? Arsipnya akan tersedia lagi di halaman publik.",
      );
      if (!confirmed) return;

      btn.disabled = true;
      btn.classList.add("opacity-60", "cursor-not-allowed");

      try {
        const res = await fetch(`${BOOKING_BASE_URL}/${id}/kembalikan`, {
          method: "PUT",
          headers: {
            "X-CSRF-TOKEN": CSRF_TOKEN,
            Accept: "application/json",
          },
        });

        if (!res.ok) throw new Error("Gagal menyimpan status.");

        const data = await res.json();

        bookingRequestsFromServer = bookingRequestsFromServer.map((item) =>
          item.id == id
            ? {
                ...item,
                status: "dikembalikan",
                dikembalikanAt: data.booking.dikembalikan_at,
              }
            : item,
        );

        renderBookingTable();
      } catch (err) {
        alert("Gagal menandai dokumen sebagai dikembalikan. Coba lagi.");
        btn.disabled = false;
        btn.classList.remove("opacity-60", "cursor-not-allowed");
      }
    });

  function formatTanggal(iso) {
    if (!iso) return "-";
    return new Date(iso).toLocaleString("id-ID", {
      dateStyle: "medium",
      timeStyle: "short",
    });
  }

  // Tanggal pengambilan cuma tanggal (tanpa jam), beda dari Tanggal & Waktu
  // yang mencatat kapan formulir dikirim.
  function formatTanggalPengambilan(tanggal) {
    if (!tanggal) return "-";
    return new Date(tanggal + "T00:00:00").toLocaleDateString("id-ID", {
      dateStyle: "medium",
    });
  }

  function renderBookingTable() {
    const requests = getBookingRequests();
    const totalEl = document.getElementById("totalCount");
    const emptyEl = document.getElementById("emptyState");
    const tableWrapper = document.getElementById("tableWrapper");
    const tbody = document.getElementById("bookingTableBody");

    totalEl.textContent = requests.length;

    if (requests.length === 0) {
      emptyEl.classList.remove("hidden");
      tableWrapper.classList.add("hidden");
      tbody.innerHTML = "";
      return;
    }

    emptyEl.classList.add("hidden");
    tableWrapper.classList.remove("hidden");

    // Terbaru di atas
    const sorted = [...requests].sort(
      (a, b) => new Date(b.tanggal) - new Date(a.tanggal),
    );

    tbody.innerHTML = sorted
      .map(
        (item, idx) => `
              <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/60 transition">
                <td class="px-6 py-4 text-slate-500">${idx + 1}</td>
                <td class="px-6 py-4 font-medium text-slate-900">${
                  item.nama || "-"
                }</td>
                <td class="px-6 py-4 text-slate-600">${item.telepon || "-"}</td>
                <td class="px-6 py-4 text-slate-600">${item.email || "-"}</td>
                <td class="px-6 py-4 text-slate-600 max-w-[220px]">${
                  item.alamat || "-"
                }</td>
                <td class="px-6 py-4 text-slate-600 min-w-[300px] max-w-[360px]">${arsipCellHTML(
                  item,
                )}</td>
                <td class="px-6 py-4 text-slate-600 max-w-[220px]">${
                  item.tujuan || "-"
                }</td>
                <td class="px-6 py-4 whitespace-nowrap">${waktuPengambilanCellHTML(item)}</td>
                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">${formatTanggal(
                  item.tanggal,
                )}</td>
                <td class="px-6 py-4 whitespace-nowrap">${statusBadgeHTML(item)}</td>
                <td class="px-6 py-4 whitespace-nowrap">${emailCellHTML(item)}</td>
                <td class="px-6 py-4 whitespace-nowrap">${aksiCellHTML(item)}</td>
              </tr>
            `,
      )
      .join("");
  }

  // Export tabel jadi file .xlsx pakai SheetJS
  document.getElementById("exportBtn").addEventListener("click", () => {
    const requests = getBookingRequests();
    if (requests.length === 0) {
      alert("Belum ada data permintaan booking untuk di-export.");
      return;
    }

    const sorted = [...requests].sort(
      (a, b) => new Date(b.tanggal) - new Date(a.tanggal),
    );

    const rows = sorted.map((item, idx) => ({
      No: idx + 1,
      "Nama Lengkap": item.nama || "-",
      "No. Telepon": item.telepon || "-",
      Email: item.email || "-",
      Alamat: item.alamat || "-",
      "Arsip yang Dibooking": formatArsip(item),
      "Tujuan Permintaan": item.tujuan || "-",
      "Tanggal Pengambilan Arsip": formatTanggalPengambilan(
        item.tanggalPengambilan,
      ),
      "Waktu Pengambilan": item.waktuPengambilan || "-",
      "Tanggal & Waktu": formatTanggal(item.tanggal),
      Status: item.status === "dikembalikan" ? "Dikembalikan" : "Diproses",
      "Email Terkirim": item.emailTerkirimAt
        ? formatTanggal(item.emailTerkirimAt)
        : "Belum",
    }));

    const worksheet = XLSX.utils.json_to_sheet(rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Permintaan Booking");

    const today = new Date().toISOString().slice(0, 10);
    XLSX.writeFile(workbook, `Permintaan-Booking-LANDAKMAS-${today}.xlsx`);
  });

  renderBookingTable();

  // Begitu admin membuka halaman ini, seluruh permintaan booking dianggap
  // sudah dilihat, supaya lingkaran notifikasi angka di sidebar (menu
  // "Permintaan Booking") hilang sampai ada permintaan baru masuk lagi.
  localStorage.setItem(
    "ardarika_booking_seen_count",
    String(getBookingRequests().length),
  );
  const bookingBadgeEl = document.getElementById("bookingBadge");
  if (bookingBadgeEl) bookingBadgeEl.classList.add("hidden");
</script>


@endsection
