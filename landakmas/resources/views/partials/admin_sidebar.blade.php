<aside class="w-[310px] shrink-0 bg-primary flex flex-col">
<!-- Logo -->
<div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
<img alt="Logo Banyumas" class="w-11 h-11 object-contain" src="{{ asset('assets/images/logo.png') }}"/>
<div>
<h1 class="text-white font-bold text-lg leading-tight">LANDAKMAS</h1>
<p class="text-slate-400 text-xs">{{ auth('admin')->user()->nama ?? 'Admin' }}</p>
</div>
</div>
<!-- Nav -->
<nav class="px-4 py-6 space-y-1 flex-1">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-soft text-primary font-semibold' : 'text-slate-300 hover:bg-white/5 hover:text-white transition' }}" href="{{ route('admin.dashboard') }}">
<svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
            Dashboard
          </a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.archive') ? 'bg-soft text-primary font-semibold' : 'text-slate-300 hover:bg-white/5 hover:text-white transition' }}" href="{{ route('admin.archive') }}">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
            Arsip
          </a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.archive.create') ? 'bg-soft text-primary font-semibold' : 'text-slate-300 hover:bg-white/5 hover:text-white transition' }}" href="{{ route('admin.archive.create') }}">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
            Tambah Arsip
          </a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl relative {{ request()->routeIs('admin.booking') ? 'bg-soft text-primary font-semibold' : 'text-slate-300 hover:bg-white/5 hover:text-white transition' }}" href="{{ route('admin.booking') }}">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
            Permintaan Booking
            <span class="hidden ml-auto bg-rose-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 px-1.5 flex items-center justify-center" id="bookingBadge"></span>
</a>
<a class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.account') ? 'bg-soft text-primary font-semibold' : 'text-slate-300 hover:bg-white/5 hover:text-white transition' }}" href="{{ route('admin.account') }}">
<span class="flex items-center gap-3">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
              Kelola Akun
            </span>
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M8.25 4.5l7.5 7.5-7.5 7.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</a>
</nav>
<!-- Notifikasi lingkaran kecil jumlah permintaan booking baru -->
<script>
  (function () {
    // Total permintaan booking sekarang dihitung di server (dari tabel
    // booking_requests), bukan lagi dibaca dari localStorage — supaya
    // jumlahnya sama persis untuk semua admin/perangkat.
    const TOTAL_FROM_SERVER = {{ \App\Models\BookingRequest::count() }};
    const SEEN_KEY = "ardarika_booking_seen_count";

    function updateBookingBadge() {
      const badge = document.getElementById("bookingBadge");
      if (!badge) return;

      const seen = parseInt(localStorage.getItem(SEEN_KEY) || "0", 10) || 0;
      const belumDilihat = Math.max(TOTAL_FROM_SERVER - seen, 0);

      if (belumDilihat > 0) {
        badge.textContent = belumDilihat > 99 ? "99+" : belumDilihat;
        badge.classList.remove("hidden");
      } else {
        badge.classList.add("hidden");
      }
    }

    updateBookingBadge();

    // Sinkron otomatis kalau tab lain baru saja menandai booking sebagai "dilihat"
    window.addEventListener("storage", (e) => {
      if (e.key === SEEN_KEY) updateBookingBadge();
    });
  })();
</script>
<!-- Bottom actions -->
<div class="px-4 py-6 space-y-3">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-secondary/90 text-white font-semibold hover:bg-secondary transition" href="{{ route('admin.landing') }}">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
            Kembali
          </a>
<form action="{{ route('admin.logout') }}" method="POST">
@csrf
<button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-rose-600 text-white font-semibold hover:bg-rose-700 transition" type="submit">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
            Keluar
          </button>
</form>
</div>
</aside>