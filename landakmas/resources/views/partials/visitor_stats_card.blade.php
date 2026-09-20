{{--
    Kartu "Statistik Pengunjung", dipakai di dua tempat dengan sumber
    data berbeda:
    - User/home.blade.php: dari tabel page_visits (kunjungan halaman
      publik), disiapkan di PublicSiteController::visitorStatsForHome().
      Di sini kartunya "live" (update sendiri tiap beberapa detik lewat
      polling ke /api/visitor-stats), lihat blok script di bawah.
    - admin/dashboard.blade.php: dari tabel booking_requests (orang
      yang sudah menyelesaikan permintaan booking), disiapkan di
      DashboardController::visitorStatsFromBookings(). Statis (tidak live).

    Variabel yang dibutuhkan: $hariIni, $mingguIni, $bulanIni,
    $tahunIni, $total, $postTerpopulerLabel, $postTerpopulerCount.
    Variabel opsional: $terpopulerCaption (default "Post Terpopuler"),
    $readerLabel (default "Pembaca"), $live (default false).
--}}
@php
    $terpopulerCaption = $terpopulerCaption ?? 'Post Terpopuler';
    $readerLabel = $readerLabel ?? 'Pembaca';
    $live = $live ?? false;
    $glass = $glass ?? false;
    $cardClasses = $glass
        ? 'bg-white/60 backdrop-blur-md border border-white/70 shadow-lg'
        : 'bg-white border border-slate-100 shadow-sm';
@endphp

<div
    @if($live) id="visitorStatsCard" data-endpoint="{{ route('visitor-stats.json') }}" @endif
    class="{{ $cardClasses }} rounded-3xl p-8 md:p-10 max-w-3xl w-full mx-auto"
>
    <div class="flex items-center justify-center gap-2">
        <p class="text-center text-blue-700 text-xs font-bold uppercase tracking-[0.2em]">
            Statistik Pengunjung
        </p>
        @if($live)
            <span class="relative flex h-2 w-2" title="Angka diperbarui otomatis">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-wide">Live</span>
        @endif
    </div>

    <div class="mt-5 h-1 w-16 bg-blue-700 rounded-full mx-auto"></div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mt-8 text-center">
        <div>
            <h4 class="text-3xl md:text-4xl font-bold text-blue-700" id="visitorStatHariIni">{{ number_format($hariIni, 0, ',', '.') }}</h4>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mt-2">Hari Ini</p>
        </div>
        <div>
            <h4 class="text-3xl md:text-4xl font-bold text-blue-700" id="visitorStatMingguIni">{{ number_format($mingguIni, 0, ',', '.') }}</h4>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mt-2">Minggu Ini</p>
        </div>
        <div>
            <h4 class="text-3xl md:text-4xl font-bold text-blue-700" id="visitorStatBulanIni">{{ number_format($bulanIni, 0, ',', '.') }}</h4>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mt-2">Bulan Ini</p>
        </div>
        <div>
            <h4 class="text-3xl md:text-4xl font-bold text-blue-700" id="visitorStatTahunIni">{{ number_format($tahunIni, 0, ',', '.') }}</h4>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mt-2">Tahun Ini</p>
        </div>
    </div>

    <div class="bg-gradient-to-r from-blue-50 to-emerald-50 border border-blue-100/70 rounded-2xl px-6 py-6 text-center mt-8">
        <h3 class="text-4xl md:text-5xl font-bold text-emerald-600" id="visitorStatTotal">{{ number_format($total, 0, ',', '.') }}</h3>
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mt-2">Total Pengunjung</p>
    </div>
</div>

@if($live)
    @push('scripts')
        <script>
            // ===================================================
            // Polling ringan buat kartu "Statistik Pengunjung" di
            // Beranda supaya angkanya kelihatan "hidup"/realtime,
            // tanpa perlu reload halaman. Setiap 15 detik, ambil
            // data terbaru dari /api/visitor-stats lalu update
            // angka yang berubah dengan animasi hitung naik.
            // ===================================================
            (function () {
                const card = document.getElementById("visitorStatsCard");
                if (!card) return;

                const endpoint = card.dataset.endpoint;
                const idFormat = (n) => Number(n).toLocaleString("id-ID");

                function animateNumber(el, newValue) {
                    if (!el) return;
                    const oldValue = parseInt(
                        (el.textContent || "0").replace(/\D/g, ""),
                        10
                    ) || 0;
                    if (oldValue === newValue) return;

                    const duration = 900;
                    const startTime = performance.now();

                    function tick(now) {
                        const progress = Math.min((now - startTime) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        const value = Math.round(
                            oldValue + (newValue - oldValue) * eased
                        );
                        el.textContent = idFormat(value);
                        if (progress < 1) {
                            requestAnimationFrame(tick);
                        } else {
                            el.textContent = idFormat(newValue);
                            el.classList.add("text-emerald-500");
                            setTimeout(() => el.classList.remove("text-emerald-500"), 700);
                        }
                    }
                    requestAnimationFrame(tick);
                }

                async function refreshStats() {
                    try {
                        const res = await fetch(endpoint, {
                            headers: { Accept: "application/json" },
                        });
                        if (!res.ok) return;
                        const data = await res.json();

                        animateNumber(document.getElementById("visitorStatHariIni"), data.hariIni);
                        animateNumber(document.getElementById("visitorStatMingguIni"), data.mingguIni);
                        animateNumber(document.getElementById("visitorStatBulanIni"), data.bulanIni);
                        animateNumber(document.getElementById("visitorStatTahunIni"), data.tahunIni);
                        animateNumber(document.getElementById("visitorStatTotal"), data.total);
                    } catch (e) {
                        // Diam-diam gagal (mis. koneksi putus) — coba lagi di
                        // interval berikutnya, jangan ganggu pengalaman user.
                    }
                }

                setInterval(refreshStats, 15000);
            })();
        </script>
    @endpush
@endif
