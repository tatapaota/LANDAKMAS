@extends('layouts.public')

@section('title', 'Cari Arsip | LANDAKMAS')

@section('content')


    <section class="bg-primary">
        <div class="max-w-4xl mx-auto px-6 py-20 text-center">
            <h1 class="font-serif text-5xl text-white">Cari Arsip</h1>
            <p class="text-slate-300 mt-5">
                Masukkan kata kunci berupa nama arsip, instansi, atau tahun untuk
                menemukan arsip yang Anda butuhkan.
            </p>
            <!-- Search -->
            <div class="mt-10">
                <div class="bg-white rounded-xl overflow-hidden flex shadow-lg">
                    <input class="flex-1 px-6 py-4 outline-none text-slate-800" id="searchInput"
                        placeholder="Cari nama arsip, instansi, atau tahun..." type="text" />
                    <button class="bg-secondary text-white px-10 font-semibold hover:bg-blue-700 transition">
                        Cari Arsip
                    </button>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-soft py-16">
        <div class="max-w-6xl mx-auto px-6">
            <p class="text-slate-700 mb-6">
                <span class="font-bold text-secondary" id="resultCount">0</span>
                arsip ditemukan
                <span class="text-slate-400 text-sm">(klik salah satu untuk melihat detail)</span>
            </p>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" id="resultList">
                <!-- Item-item diisi oleh JavaScript di bawah -->
            </div>
            <p class="hidden text-center text-slate-500 py-16 bg-white rounded-2xl shadow-lg mt-2" id="emptyState">
                Tidak ada arsip yang cocok dengan pencarian kamu.
            </p>
            <!-- Pagination, di-generate otomatis sesuai jumlah hasil -->
            <div class="flex justify-center gap-2 mt-10" id="paginationWrap"></div>
        </div>
    </section>


    <div class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4" id="archiveModal">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative max-h-[90vh] overflow-y-auto">
            <button aria-label="Tutup"
                class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-3xl leading-none" id="closeModalBtn">
                ×
            </button>
            <div class="flex items-center gap-4 mb-6 pr-8">
                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center shrink-0" id="modalCoverWrap">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.5 21V8.25a2.25 2.25 0 00-.659-1.591l-4.5-4.5A2.25 2.25 0 0012.75 1.5H6A2.25 2.25 0 003.75 3.75v16.5A2.25 2.25 0 006 22.5h11.25A2.25 2.25 0 0019.5 21z"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div>
                    <span class="bg-primary text-white px-4 py-1.5 rounded-full text-sm font-semibold"
                        id="modalNo"></span>
                </div>
            </div>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Kode Klasifikasi</span>
                    <span class="font-semibold bg-slate-200 px-2 py-1 rounded" id="modalKode"></span>
                </div>
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Instansi</span>
                    <span class="font-semibold" id="modalInstansi"></span>
                </div>
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Tahun</span>
                    <span class="font-semibold" id="modalTahun"></span>
                </div>
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Status</span>
                    <span id="modalStatus"></span>
                </div>
                <div>
                    <span class="text-slate-500 block mb-1">Uraian</span>
                    <p class="text-slate-700 leading-7" id="modalUraian"></p>
                </div>
            </div>
        </div>
    </div>


    <div class="hidden fixed bottom-6 right-6 z-[60] max-w-sm rounded-xl shadow-lg px-6 py-4 text-sm font-medium text-white"
        id="bookingToast"></div>

    <script>
        // Data arsip diambil langsung dari database (lewat controller
        // PublicSiteController@archive -> $arsipsJs).
        const archiveResults = @json($arsipsJs);

        // Cover: kalau arsip punya media gambar, gambar pertama dipakai sebagai
        // cover — sama seperti perilaku di Daftar Arsip admin. Kalau tidak ada
        // gambar, tampilkan ikon dokumen generik seperti sebelumnya.
        function coverThumbHTML(item) {
            const cover = (item.media || []).find((m) => m.isImage && m.dataUrl);
            if (cover) {
                return `<img src="${cover.dataUrl}" class="w-14 h-14 rounded-xl object-cover shrink-0 border border-slate-200" alt="Cover ${item.uraian}" onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('div'), {className:'w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center shrink-0'}, {innerHTML: iconSVG}));" />`;
            }
            return `<div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">${iconSVG}</div>`;
        }

        // Menyimpan hasil yang sedang ditampilkan (bisa hasil filter pencarian)
        // supaya bisa dirender ulang setelah aksi booking tanpa kehilangan filter.
        let currentResults = archiveResults;

        // Pengaman: kalau assets/js/keranjang.js gagal dimuat (mis. file belum
        // diupload ke server), buat fungsi kosong supaya daftar arsip di bawah
        // tetap tampil normal — hanya fitur booking yang nonaktif.
        if (typeof getKeranjang !== "function") {
            console.warn(
                "assets/js/keranjang.js tidak termuat. Pastikan file tersebut ada di folder proyek (assets/js/keranjang.js). Fitur booking dinonaktifkan sementara.",
            );
            window.KERANJANG_KEY = "ardarika_keranjang";
            window.BOOKING_LOCK_KEY = "ardarika_booking_lock";
            window.getKeranjang = () => [];
            window.isArsipLocked = () => false;
            window.addToKeranjang = () => true;
            window.removeFromKeranjang = () => {};
            window.syncBookingLockWithServer = () => {};
        }

        // Lepas kunci lokal (localStorage) untuk arsip yang menurut server
        // sudah "tersedia" lagi (mis. admin baru saja klik "Kembalikan
        // Dokumen"), supaya badge "Tidak Tersedia" / "Sudah Dibooking" di
        // browser ini tidak nyangkut selamanya.
        if (typeof syncBookingLockWithServer === "function") {
            syncBookingLockWithServer(archiveResults);
        }

        const iconSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-blue-600">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 21V8.25a2.25 2.25 0 00-.659-1.591l-4.5-4.5A2.25 2.25 0 0012.75 1.5H6A2.25 2.25 0 003.75 3.75v16.5A2.25 2.25 0 006 22.5h11.25A2.25 2.25 0 0019.5 21z" />
        </svg>`;

        function statusBadgeHTML(item) {
            // Status "Tidak Tersedia" muncul kalau memang statusnya begitu dari
            // awal, ATAU kalau arsip ini sudah dikunci/dibooking (oleh siapa pun).
            const terkunci = isArsipLocked(item.id);
            const isTersedia = item.status !== "tidak-tersedia" && !terkunci;
            const colorClasses = isTersedia ?
                "bg-emerald-100 text-emerald-700" :
                "bg-rose-100 text-rose-700";
            const dotClass = isTersedia ? "bg-emerald-500" : "bg-rose-500";
            const label = isTersedia ? "Tersedia" : "Tidak Tersedia";

            return `
          <span class="status-badge inline-flex items-center gap-1.5 ${colorClasses} px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap" data-status="${isTersedia ? "tersedia" : "tidak-tersedia"}">
            <span class="w-1.5 h-1.5 rounded-full ${dotClass}"></span>
            ${label}
          </span>`;
        }

        // ===== Tombol Booking Arsip (fitur baru) =====
        function bookingButtonHTML(item) {
            if (item.status === "tidak-tersedia") {
                return `<span class="text-xs text-slate-400 italic">Tidak dapat dibooking</span>`;
            }

            const sudahDiKeranjangSaya = getKeranjang().some(
                (k) => String(k.id) === String(item.id),
            );
            const terkunci = isArsipLocked(item.id);

            if (sudahDiKeranjangSaya) {
                return `
            <button type="button" onclick="event.stopPropagation(); handleHapusBooking('${item.id}')" class="text-xs font-semibold text-emerald-600 border border-emerald-300 bg-emerald-50 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition whitespace-nowrap">
              ✓ Di Keranjang Anda
            </button>`;
            }

            if (terkunci) {
                return `
            <span class="text-xs font-semibold text-slate-400 border border-slate-200 bg-slate-100 px-3 py-1.5 rounded-lg inline-block whitespace-nowrap">
              Sudah Dibooking
            </span>`;
            }

            return `
          <button type="button" onclick="event.stopPropagation(); handleBooking('${item.id}')" class="text-xs font-semibold text-blue-600 border border-blue-300 bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition whitespace-nowrap">
            + Booking Arsip
          </button>`;
        }

        // Notifikasi kecil di pojok layar (menggantikan alert() yang mengganggu)
        function showBookingToast(message, isError) {
            const toast = document.getElementById("bookingToast");
            if (!toast) {
                alert(message);
                return;
            }
            toast.textContent = message;
            toast.className =
                "fixed bottom-6 right-6 z-[60] max-w-sm rounded-xl shadow-lg px-6 py-4 text-sm font-medium text-white " +
                (isError ? "bg-rose-600" : "bg-emerald-600");
            clearTimeout(window.__bookingToastTimer);
            window.__bookingToastTimer = setTimeout(() => {
                toast.classList.add("hidden");
            }, 4000);
        }

        function handleBooking(id) {
            const item = archiveResults.find((a) => String(a.id) === String(id));
            if (!item) return;

            const berhasil = addToKeranjang({
                id: item.id,
                no: item.no,
                instansi: item.instansi,
                kode: item.kode,
                tahun: item.tahun,
                uraian: item.uraian,
            });

            renderResults(currentResults);

            if (berhasil) {
                showBookingToast(
                    'Arsip ditambahkan ke keranjang. Buka menu "Permintaan Arsip" di navbar untuk melanjutkan.',
                );
            } else {
                showBookingToast(
                    "Maaf, arsip ini baru saja dibooking oleh pengguna lain. Silakan pilih arsip lain.",
                    true,
                );
            }
        }

        function handleHapusBooking(id) {
            removeFromKeranjang(id);
            renderResults(currentResults);
            showBookingToast("Arsip dikeluarkan dari keranjang.");
        }
        // ===== Selesai bagian Booking Arsip =====

        // Arsip harus selalu tampil urut berdasarkan Kode Klasifikasi, bukan
        // urutan sembarangan — sama seperti aturan urutan di Daftar Arsip admin.
        function parseKodeParts(kode) {
            return String(kode || "")
                .split(".")
                .map((part) => {
                    const n = parseInt(part, 10);
                    return isNaN(n) ? 0 : n;
                });
        }

        function compareKode(a, b) {
            const pa = parseKodeParts(a);
            const pb = parseKodeParts(b);
            const len = Math.max(pa.length, pb.length);
            for (let i = 0; i < len; i++) {
                const diff = (pa[i] || 0) - (pb[i] || 0);
                if (diff !== 0) return diff;
            }
            return 0;
        }

        function sortByKode(list) {
            return [...list].sort((a, b) => compareKode(a.kode, b.kode));
        }

        const PAGE_SIZE = 10;
        const MAX_PAGE_BUTTONS = 5;
        let currentPage = 1;

        function renderPagination(totalItems) {
            const wrap = document.getElementById("paginationWrap");
            const totalPages = Math.max(1, Math.ceil(totalItems / PAGE_SIZE));

            if (currentPage > totalPages) currentPage = totalPages;

            if (totalPages <= 1) {
                wrap.innerHTML = "";
                return;
            }

            // Nomor halaman dibatasi maksimal 5 biji supaya tidak
            // memanjang sampai puluhan/ratusan tombol kalau arsipnya
            // banyak — jendela nomornya digeser mengikuti currentPage,
            // dan diapit tombol "Back"/"Next" buat pindah per satu
            // halaman.
            let startPage = Math.max(1, currentPage - Math.floor(MAX_PAGE_BUTTONS / 2));
            let endPage = startPage + MAX_PAGE_BUTTONS - 1;

            if (endPage > totalPages) {
                endPage = totalPages;
                startPage = Math.max(1, endPage - MAX_PAGE_BUTTONS + 1);
            }

            const navBtnClass =
                "px-4 h-10 rounded-lg font-semibold transition bg-white border border-slate-300 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white";

            let buttons = `
        <button onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? "disabled" : ""} class="${navBtnClass}">Back</button>`;

            for (let p = startPage; p <= endPage; p++) {
                const active = p === currentPage;
                buttons += `
        <button
          onclick="goToPage(${p})"
          class="w-10 h-10 rounded-lg font-semibold transition ${active ? "bg-primary text-white" : "bg-white border border-slate-300 text-slate-600 hover:bg-slate-100"}"
        >${p}</button>`;
            }

            buttons += `
        <button onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? "disabled" : ""} class="${navBtnClass}">Next</button>`;

            wrap.innerHTML = buttons;
        }

        function goToPage(page) {
            const totalPages = Math.max(1, Math.ceil(currentResults.length / PAGE_SIZE));
            page = Math.min(Math.max(1, page), totalPages);
            if (page === currentPage) return;

            currentPage = page;
            renderResults(currentResults, false);
            window.scrollTo({
                top: document.getElementById("resultList").offsetTop - 100,
                behavior: "smooth"
            });
        }

        function renderResults(data, resetPage = true) {
            data = sortByKode(data);
            currentResults = data;
            if (resetPage) currentPage = 1;

            document.getElementById("resultCount").textContent = data.length;

            const listEl = document.getElementById("resultList");
            const emptyEl = document.getElementById("emptyState");

            if (data.length === 0) {
                listEl.classList.add("hidden");
                emptyEl.classList.remove("hidden");
                renderPagination(0);
                return;
            }
            listEl.classList.remove("hidden");
            emptyEl.classList.add("hidden");

            const start = (currentPage - 1) * PAGE_SIZE;
            const pageData = data.slice(start, start + PAGE_SIZE);

            listEl.innerHTML = pageData
                .map(
                    (item, idx) => `
              <div
                class="flex justify-between gap-6 ${idx !== pageData.length - 1 ? "border-b border-slate-200" : ""} px-8 py-8 cursor-pointer hover:bg-slate-50 transition"
                onclick="openArchiveModal(currentResults[${start + idx}])"
              >
                <div class="flex gap-5">
                  ${coverThumbHTML(item)}
                  <div>
                    <div class="flex flex-wrap gap-5 text-sm">
                      <p><strong>Kode Klasifikasi:</strong> <span class="bg-slate-200 px-2 py-1 rounded">${item.kode}</span></p>
                      <p><strong>Instansi:</strong> ${item.instansi}</p>
                      <p><strong>Tahun:</strong> ${item.tahun}</p>
                    </div>
                    <div class="mt-3">
                      <strong>Uraian:</strong>
                      <p class="text-slate-600 mt-1 leading-7">${item.uraian}</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-3 shrink-0">
                  <span class="bg-primary text-white px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap">
                    No.${item.no}
                  </span>
                  ${statusBadgeHTML(item)}
                  ${bookingButtonHTML(item)}
                </div>
              </div>
            `,
                )
                .join("");

            renderPagination(data.length);
        }

        renderResults(archiveResults);
const urlParams = new URLSearchParams(window.location.search);
const initialQuery = urlParams.get("q");
if (initialQuery) {
    document.getElementById("searchInput").value = initialQuery;
    document.getElementById("searchInput").dispatchEvent(new Event("input"));
}
        // Sinkron otomatis kalau keranjang/kunci booking berubah dari tab lain
        window.addEventListener("storage", (e) => {
            if (e.key === KERANJANG_KEY || e.key === BOOKING_LOCK_KEY) {
                renderResults(currentResults);
            }
        });

        // Pencarian sederhana di sisi client (dummy, filter dari data di atas)
        document.getElementById("searchInput").addEventListener("input", (e) => {
            const keyword = e.target.value.toLowerCase().trim();
            const filtered = archiveResults.filter(
                (a) =>
                a.uraian.toLowerCase().includes(keyword) ||
                a.kode.toLowerCase().includes(keyword) ||
                a.instansi.toLowerCase().includes(keyword) ||
                String(a.tahun).includes(keyword),
            );
            renderResults(filtered);
        });

        // Modal logic
        function openArchiveModal(data) {
            // Cover gambar untuk item ini (kalau ada); kalau tidak, tetap ikon default.
            const cover = (data.media || []).find((m) => m.isImage && m.dataUrl);
            document.getElementById("modalCoverWrap").innerHTML = cover ?
                `<img src="${cover.dataUrl}" class="w-full h-full rounded-xl object-cover" alt="Cover arsip" />` :
                `<svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M19.5 21V8.25a2.25 2.25 0 00-.659-1.591l-4.5-4.5A2.25 2.25 0 0012.75 1.5H6A2.25 2.25 0 003.75 3.75v16.5A2.25 2.25 0 006 22.5h11.25A2.25 2.25 0 0019.5 21z" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>`;
            document.getElementById("modalNo").textContent = "No." + data.no;
            document.getElementById("modalKode").textContent = data.kode;
            document.getElementById("modalInstansi").textContent = data.instansi;
            document.getElementById("modalTahun").textContent = data.tahun;
            document.getElementById("modalUraian").textContent = data.uraian;
            document.getElementById("modalStatus").innerHTML =
                statusBadgeHTML(data);

            const modal = document.getElementById("archiveModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            document.body.classList.add("overflow-hidden");
        }

        function closeArchiveModal() {
            const modal = document.getElementById("archiveModal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            document.body.classList.remove("overflow-hidden");
        }

        document
            .getElementById("closeModalBtn")
            .addEventListener("click", closeArchiveModal);

        document.getElementById("archiveModal").addEventListener("click", (e) => {
            if (e.target.id === "archiveModal") closeArchiveModal();
        });

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") closeArchiveModal();
        });
    </script>


@endsection
