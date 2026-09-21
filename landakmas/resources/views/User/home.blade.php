@extends('layouts.public')

@section('title', 'LANDAKMAS | Dinas Arsip Kabupaten Banyumas')

@section('content')


    <section class="bg-primary">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center px-6 py-20">
                <!-- LEFT -->
                <div>
                    <h1 class="font-serif text-white text-6xl leading-tight">
                        Layanan Digital,<br />
                        <span class="text-blue-300"> Kearsipan Banyumas </span>
                    </h1>
                    <p class="text-slate-300 mt-8 leading-8">
                        LANDAKMAS merupakan sistem informasi pencarian arsip publik yang
                        dikembangkan untuk mendukung transparansi dan kemudahan akses
                        informasi di Dinas Arsip dan Perpustakaan Daerah Kabupaten
                        Banyumas.
    
                    </p>
                    <!-- Search -->
                    <div class="mt-10">
                        <form action="{{ route('archive') }}" class="bg-white rounded-xl overflow-hidden flex shadow-lg"
                            method="GET">
                            <input class="flex-1 px-6 py-4 outline-none text-slate-800" id="heroSearchInput" name="q"
                                placeholder="Cari nama arsip, instansi, atau tahun..." type="text" />
                            <button class="bg-secondary text-white px-10 hover:bg-blue-700 transition" type="submit">
                                Cari Arsip
                            </button>
                        </form>
                    </div>
                </div>
                <!-- RIGHT -->
               <div class="flex justify-center items-start -mt-24">
                    <img alt="Ilustrasi Arsip" class="w-[520px] lg:w-[560px] object-contain"
                        src="{{ asset('assets/images/hero.png') }}?v=2" />
                </div>
            </div>
        </div>
    </section>


    <section class="relative bg-[#F8FAFC] py-24 overflow-hidden min-h-[1100px]" id="statistikSection">
        <!-- Background Gedung -->
        <div class="absolute inset-0 pointer-events-none">
            <img alt="Gedung LANDAKMAS" class="w-full h-full object-cover object-center opacity-95"
                src="{{ asset('assets/images/gedung.png') }}" />
            <!-- Overlay gradient tipis, hanya menebal di atas & bawah supaya teks tetap terbaca -->
        </div>
        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-6">
            <!-- Statistik Pengunjung: kartu transparan (glass) supaya gedung di
                 belakangnya tetap kelihatan, senada dengan section ini -->
            @include('partials.visitor_stats_card', [
                'hariIni' => $hariIni,
                'mingguIni' => $mingguIni,
                'bulanIni' => $bulanIni,
                'tahunIni' => $tahunIni,
                'total' => $total,
                'postTerpopulerLabel' => $postTerpopulerLabel,
                'postTerpopulerCount' => $postTerpopulerCount,
                'live' => true,
                'glass' => true,
            ])

            <!-- Judul -->
            <div class="text-center mt-20">
                <h2 class="font-serif text-5xl text-slate-900">Informasi Arsip</h2>
                <p class="text-slate-500 mt-4">
                    Berikut merupakan informasi statistik terkini mengenai arsip yang
                    tersedia di Dinas Arsip dan Perpustakaan Daerah Kabupaten Banyumas.
                </p>
            </div>
            <!-- Garis Statistik -->
            <div class="mt-14">
                <div class="w-full h-1 bg-blue-700 rounded-full"></div>
            </div>
            <div class="grid lg:grid-cols-3 gap-10 mt-10 text-center">
                <!-- Total Arsip -->
                <div>
                    <h3 class="text-5xl font-bold text-blue-700" data-target="{{ $statTotalArsip }}" id="statTotalArsip">
                        0
                    </h3>
                    <p class="mt-3 text-slate-600">Total Arsip Terdaftar</p>
                </div>
                <!-- Instansi -->
                <div>
                    <h3 class="text-5xl font-bold text-blue-700" data-target="{{ $statTotalInstansi }}" id="statInstansi">
                        0
                    </h3>
                    <p class="mt-3 text-slate-600">Instansi / OPD Terhubung</p>
                </div>
                <!-- Tahun -->
                <div>
                    <h3 class="text-5xl font-bold text-blue-700">
                        <span data-target="{{ $statTahunAwal }}" id="statTahunAwal">0</span>–<span
                            data-target="{{ $statTahunAkhir }}" id="statTahunAkhir">0</span>
                    </h3>
                    <p class="mt-3 text-slate-600">Rentang Tahun Arsip</p>
                </div>
            </div>
            <div class="mt-24">
                <small class="uppercase tracking-widest text-slate-500">
                    Jelajahi Berdasarkan Instansi
                </small>
                <h3 class="font-serif text-4xl mt-3">Instansi</h3>
            </div>
            <div class="grid lg:grid-cols-4 gap-6 mt-10">
                @forelse ($featuredInstitutions as $inst)
                    <a class="block bg-white rounded-2xl shadow-lg p-6 hover:-translate-y-1 hover:shadow-xl duration-300 cursor-pointer"
                        href="{{ route('institution.detail', ['instansi' => $inst['slug']]) }}">
                        <h1 class="font-serif text-5xl text-primary">{{ str_pad($inst['jumlah'], 3, '0', STR_PAD_LEFT) }}
                        </h1>
                        <h4 class="font-bold mt-3">{{ $inst['nama'] }}</h4>
                        <p class="text-slate-500 mt-1">{{ $inst['jumlah'] }} arsip tersimpan</p>
                        <span class="inline-block mt-5 text-blue-600 font-semibold">
                            Lihat Arsip →
                        </span>
                    </a>
                @empty
                    <p class="col-span-full text-slate-500 py-6">Belum ada arsip yang tersimpan untuk instansi manapun.</p>
                @endforelse
                <a class="block bg-white rounded-2xl shadow-lg flex flex-col justify-center items-center p-6 hover:shadow-xl duration-300 cursor-pointer"
                    href="{{ route('institution') }}">
                    <h3 class="font-bold text-xl">Semua Instansi</h3>
                    <span class="mt-4 text-blue-600 font-semibold">
                        Lihat Daftar →
                    </span>
                </a>
            </div>
        </div>
    </section>


    <section class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="font-serif text-4xl text-slate-900">
                Arsip yang Sering Diakses
            </h2>
            <p class="text-slate-500 mt-3">
                Daftar arsip yang paling banyak diakses oleh masyarakat.
                <span class="text-slate-400">(Klik salah satu arsip untuk melihat detailnya)</span>
            </p>
            <div class="mt-10 bg-slate-50 rounded-3xl shadow-xl p-8" id="homeArchiveList">
                <!-- Item-item diisi oleh JavaScript di bawah -->
            </div>
        </div>
    </section>


    <div class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4" id="archiveModal">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative max-h-[90vh] overflow-y-auto">
            <button aria-label="Tutup"
                class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-3xl leading-none" id="closeModalBtn">
                ×
            </button>
            <div class="flex items-center gap-4 mb-6 pr-8">
                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
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
        // Arsip terbaru yang ditampilkan di beranda, diambil langsung dari
        // database (lewat controller PublicSiteController@home).
        const homeArchives = @json($homeArchivesJs);

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
            syncBookingLockWithServer(homeArchives);
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
            const item = homeArchives.find((a) => String(a.id) === String(id));
            if (!item) return;

            const berhasil = addToKeranjang({
                id: item.id,
                no: item.no,
                instansi: item.instansi,
                kode: item.kode,
                tahun: item.tahun,
                uraian: item.uraian,
            });

            renderHomeArchives();

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
            renderHomeArchives();
            showBookingToast("Arsip dikeluarkan dari keranjang.");
        }
        // ===== Selesai bagian Booking Arsip =====

        function renderHomeArchives() {
            const listEl = document.getElementById("homeArchiveList");
            listEl.innerHTML = homeArchives
                .map(
                    (item, idx) => `
              <div
                class="flex justify-between gap-6 ${idx !== homeArchives.length - 1 ? "border-b border-slate-200" : ""} py-6 px-3 -mx-3 rounded-xl cursor-pointer hover:bg-white hover:shadow-md transition"
                onclick="openArchiveModal(homeArchives[${idx}])"
              >
                <div class="flex gap-5">
                  <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                    ${iconSVG}
                  </div>
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
        }

        renderHomeArchives();

        // Sinkron otomatis kalau keranjang/kunci booking berubah dari tab lain
        window.addEventListener("storage", (e) => {
            if (e.key === KERANJANG_KEY || e.key === BOOKING_LOCK_KEY) {
                renderHomeArchives();
            }
        });

        // ===========================================================
        // Animasi angka statistik "hitung naik" (Total Arsip, Instansi,
        // Rentang Tahun) — jalan otomatis begitu section-nya kelihatan
        // di layar (pakai IntersectionObserver, bukan cuma pas load).
        // ===========================================================
        function animateCounter(el, target, options = {}) {
            if (!el) return;
            const duration = options.duration || 1600;
            const formatter =
                options.formatter || ((n) => n.toLocaleString("id-ID"));
            const startTime = performance.now();

            function tick(now) {
                const progress = Math.min((now - startTime) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3); // ease-out
                const value = Math.round(target * eased);
                el.textContent = formatter(value);
                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    el.textContent = formatter(target);
                }
            }
            requestAnimationFrame(tick);
        }

        function runStatCounters() {
            const statEls = [{
                    el: document.getElementById("statTotalArsip")
                },
                {
                    el: document.getElementById("statInstansi"),
                    options: {
                        formatter: (n) => n.toString()
                    },
                },
                {
                    el: document.getElementById("statTahunAwal"),
                    options: {
                        formatter: (n) => n.toString(),
                        duration: 1200
                    },
                },
                {
                    el: document.getElementById("statTahunAkhir"),
                    options: {
                        formatter: (n) => n.toString(),
                        duration: 1200
                    },
                },
            ];

            statEls.forEach(({
                el,
                options
            }) => {
                if (!el) return;
                const target = parseInt(el.dataset.target, 10) || 0;
                animateCounter(el, target, options);
            });
        }

        const statistikSection = document.getElementById("statistikSection");
        if (statistikSection && "IntersectionObserver" in window) {
            const statObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            runStatCounters();
                            statObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.4
                },
            );
            statObserver.observe(statistikSection);
        } else {
            // Fallback kalau browser tidak dukung IntersectionObserver
            runStatCounters();
        }

        // Modal logic
        function openArchiveModal(data) {
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