<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Portal Admin | LANDAKMAS</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
      rel="stylesheet"
    />

    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: "#112240",
              secondary: "#2563EB",
              soft: "#F8FAFC",
            },
            fontFamily: {
              sans: ["Inter"],
              serif: ["Playfair Display"],
            },
          },
        },
      };
    </script>
  </head>

  <body class="bg-white font-sans text-slate-800">
    <!-- ===========================
            NAVBAR (khusus Admin)
    ============================ -->
    <nav class="bg-primary border-b border-slate-600">
      <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between py-5 px-6">
          <!-- Logo -->
          <div class="flex items-center gap-4">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Banyumas" class="w-16 h-16 object-contain" />
            <div>
              <h1 class="text-white font-bold text-3xl">LANDAKMAS</h1>
              <p class="text-slate-300 text-sm">Portal Admin Dinas Arsip dan Perpustakaan Daerah Kabupaten Banyumas</p>
            </div>
          </div>

          <!-- Menu -->
          <div class="hidden lg:flex items-center gap-10">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-blue-300 transition">Dasbor</a>
            <a href="{{ route('admin.archive') }}" class="text-slate-300 hover:text-blue-300 transition">Arsip</a>

            <!-- Tombol Masuk / Area Profil -->
            <a id="masukBtn" href="{{ route('admin.login') }}" class="bg-white text-primary px-6 py-2 rounded-xl font-semibold hover:bg-slate-100 transition">
              Masuk
            </a>

            <div id="profileArea" class="relative hidden">
              <button id="profileBtn" type="button" class="w-11 h-11 rounded-full border-2 border-white/70 flex items-center justify-center text-white hover:bg-white/10 transition" aria-label="Akun">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </button>
              <div id="profileDropdown" class="hidden absolute right-0 mt-3 bg-white rounded-xl shadow-xl py-2 px-1 w-44 z-50">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-slate-700 font-medium rounded-lg hover:bg-slate-100 transition text-sm">
                  Ke Dashboard
                </a>
                <button id="logoutBtn" type="button" class="flex items-center gap-2 w-full text-left px-3 py-2 text-secondary font-semibold rounded-lg hover:bg-slate-100 transition text-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                  </svg>
                  Keluar
                </button>
                <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                  @csrf
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- ===========================
        HERO
    ============================ -->
    <section class="bg-primary">
      <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-12 items-center px-6 py-20">
          <div>
            <span class="inline-block bg-white/10 text-blue-300 text-xs font-semibold tracking-wide px-4 py-1.5 rounded-full mb-6">
              KHUSUS PETUGAS ARSIP
            </span>
            <h1 class="font-serif text-white text-6xl leading-tight">
              Portal Admin,<br />
              <span class="text-blue-300">Kelola Arsip Daerah</span>
            </h1>
            <p class="text-slate-300 mt-8 leading-8">
              Halaman ini khusus untuk admin Dinas Arsip dan Perpustakaan Daerah Kabupaten Banyumas mengelola data
              arsip, instansi, dan permintaan booking. Masyarakat umum silakan gunakan halaman pencarian arsip publik.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-4">
              <a id="ctaLoginBtn" href="{{ route('admin.login') }}" class="text-center bg-secondary text-white font-semibold rounded-xl py-4 px-10 shadow-lg hover:bg-blue-700 transition">
                Masuk sebagai Admin
              </a>
            </div>
          </div>

          <div class="flex justify-center items-start -mt-[6rem]">
            <img src="{{ asset('assets/images/hero.png') }}" alt="Ilustrasi Arsip" class="w-[520px] lg:w-[560px] object-contain" />
          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================
        INFORMASI ARSIP
    =========================================== -->
    <section id="statistikSection" class="relative bg-[#F8FAFC] pt-10 pb-24 overflow-hidden">
      <div class="absolute top-0 left-0 w-full pointer-events-none">
        <img src="{{ asset('assets/images/gedung.png') }}" alt="Gedung LANDAKMAS" class="w-full h-auto object-contain object-top opacity-95" />
      </div>

      <div class="relative max-w-7xl mx-auto px-6">
        <div class="text-center">
          <h2 class="font-serif text-5xl text-slate-900">Ringkasan Sistem</h2>
          <p class="text-slate-500 mt-4">
            Gambaran singkat data arsip yang sedang dikelola di Dinas Arsip dan Perpustakaan Daerah Kabupaten Banyumas.
          </p>
        </div>

        <div class="mt-14">
          <div class="w-full h-1 bg-blue-700 rounded-full"></div>
        </div>

        <div class="grid lg:grid-cols-3 gap-10 mt-10 text-center">
          <div>
            <h3 id="statTotalArsip" class="text-5xl font-bold text-blue-700" data-target="{{ $statTotalArsip }}">0</h3>
            <p class="mt-3 text-slate-600">Total Arsip Terdaftar</p>
          </div>
          <div>
            <h3 id="statInstansi" class="text-5xl font-bold text-blue-700" data-target="{{ $statTotalInstansi }}">0</h3>
            <p class="mt-3 text-slate-600">Instansi / OPD Terhubung</p>
          </div>
          <div>
            <h3 class="text-5xl font-bold text-blue-700">
              <span id="statTahunAwal" data-target="{{ $statTahunAwal }}">0</span>–<span id="statTahunAkhir" data-target="{{ $statTahunAkhir }}">0</span>
            </h3>
            <p class="mt-3 text-slate-600">Rentang Tahun Arsip</p>
          </div>
        </div>

        <div class="mt-24 text-center" id="loginCtaBlock">
          <h2 class="font-serif text-3xl text-slate-900">Masuk untuk mulai mengelola arsip</h2>
          <p class="text-slate-500 mt-3">
            Login menggunakan akun admin untuk membuka Dashboard, Daftar Arsip, dan Permintaan Booking.
          </p>
          <a href="{{ route('admin.login') }}" class="inline-block mt-8 bg-primary text-white font-semibold rounded-xl px-10 py-4 hover:bg-slate-800 transition">
            Masuk sebagai Admin
          </a>
        </div>

        <!-- ==========================================
            DAFTAR ARSIP (khusus tampil kalau admin sudah login)
        =========================================== -->
        <div class="hidden mt-24" id="daftarArsipSection">
          <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
              <h2 class="font-serif text-3xl text-slate-900">Daftar Arsip</h2>
              <p class="text-slate-500 mt-2">Cuplikan arsip yang sedang dikelola. Sama seperti daftar arsip publik, hanya saja tanpa kolom Instansi.</p>
            </div>
            <a href="{{ route('admin.archive') }}" class="shrink-0 bg-primary text-white font-semibold rounded-xl px-6 py-3 hover:bg-slate-800 transition">
              Kelola di Daftar Arsip &rarr;
            </a>
          </div>

          <div class="bg-white rounded-2xl shadow-lg overflow-hidden text-left" id="landingArsipList"></div>
        </div>
      </div>
    </section>

    <!-- ==========================================
        FOOTER
    =========================================== -->
    <footer id="footerContact" class="bg-primary text-white">
      <div class="max-w-7xl mx-auto px-6 py-16 text-center">
        <h2 class="font-serif text-4xl">Tertib Arsip Tertib Hidup</h2>
        <p class="text-slate-300 mt-6">Portal internal untuk petugas Dinas Arsip dan Perpustakaan Daerah Kabupaten Banyumas.</p>
        <p class="text-slate-400 text-xs mt-3 tracking-wide">LANDAKMAS — Layanan Digital, Kearsipan Banyumas</p>
        <p class="text-slate-400 mt-8">Jl. Jenderal Gatot Subroto, Purwokerto, Kabupaten Banyumas, Jawa Tengah 53116</p>
        <p class="text-slate-400 mt-2">Telp/Fax. : (0281) 636115, (0281) 635967</p>

        <div class="flex items-center justify-center gap-4 mt-6">
          <a href="https://www.instagram.com/dinarpusbanyumas?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="hover:opacity-80 transition-opacity">
            <img src="{{ asset('assets/images/instagram.png') }}" alt="Instagram" class="w-10 h-10" />
          </a>
          <a href="https://youtube.com/@arsipdanperpustakaanbanyum4052?si=5-wl81Ttz0naxUTE" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="hover:opacity-80 transition-opacity">
            <img src="{{ asset('assets/images/youtube.png') }}" alt="YouTube" class="w-12 h-12" />
          </a>
        </div>
      </div>

      <div class="border-t border-slate-700">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-slate-400 text-sm">
          © 2026 LANDAKMAS | Dirancang dan dibuat oleh Cinta HB dan Hanah NA Mahasiswa Telkom University Purwokerto.
        </div>
      </div>
    </footer>

    <script>
      // ============================================================
      // Tampilan navbar kanan: tombol "Masuk" kalau belum login,
      // atau ikon profil + dropdown "Keluar" kalau admin sudah login
      // (dipakai saat admin kembali ke /admin setelah login sebelumnya).
      // ============================================================
      // Cuplikan Daftar Arsip di beranda admin, diambil langsung dari
      // database (lewat controller AuthController@landing), sama seperti
      // Daftar Arsip publik hanya saja tanpa kolom Instansi.
      const landingArsipData = @json($landingArsipJs);

      function renderLandingArsipList() {
        const wrap = document.getElementById("landingArsipList");
        if (!wrap) return;

        if (landingArsipData.length === 0) {
          wrap.innerHTML = `
            <div class="px-8 py-10 text-center text-slate-400">
              Belum ada arsip yang tersimpan di database.
            </div>
          `;
          return;
        }

        wrap.innerHTML = landingArsipData
          .map(
            (item, idx) => `
              <div class="flex justify-between gap-6 ${idx !== landingArsipData.length - 1 ? "border-b border-slate-200" : ""} px-8 py-6">
                <div>
                  <div class="flex flex-wrap gap-5 text-sm">
                    <p><strong>Kode Klasifikasi:</strong> <span class="bg-slate-200 px-2 py-1 rounded">${item.kode}</span></p>
                    <p><strong>No. Definitif:</strong> ${item.noDefinitif}</p>
                    <p><strong>Tahun:</strong> ${item.tahun}</p>
                  </div>
                  <div class="mt-3">
                    <strong>Uraian:</strong>
                    <p class="text-slate-600 mt-1 leading-7">${item.uraian}</p>
                  </div>
                </div>
                <span class="shrink-0 bg-primary text-white px-5 py-2 rounded-full text-sm font-semibold h-fit whitespace-nowrap">
                  No.${idx + 1}
                </span>
              </div>
            `,
          )
          .join("");
      }
      renderLandingArsipList();

      function updateAuthUI() {
        const isLoggedIn = @json($isLoggedIn);
        const masukBtn = document.getElementById("masukBtn");
        const profileArea = document.getElementById("profileArea");
        const ctaLoginBtn = document.getElementById("ctaLoginBtn");
        const loginCtaBlock = document.getElementById("loginCtaBlock");
        const daftarArsipSection = document.getElementById("daftarArsipSection");

        if (isLoggedIn) {
          masukBtn.classList.add("hidden");
          profileArea.classList.remove("hidden");
          ctaLoginBtn.textContent = "Lihat Arsip";
          ctaLoginBtn.href = "{{ route('admin.archive') }}";
          loginCtaBlock.classList.add("hidden");
          daftarArsipSection.classList.remove("hidden");
        } else {
          masukBtn.classList.remove("hidden");
          profileArea.classList.add("hidden");
          ctaLoginBtn.textContent = "Masuk sebagai Admin";
          ctaLoginBtn.href = "{{ route('admin.login') }}";
          loginCtaBlock.classList.remove("hidden");
          daftarArsipSection.classList.add("hidden");
        }
      }
      updateAuthUI();

      const profileBtn = document.getElementById("profileBtn");
      const profileDropdown = document.getElementById("profileDropdown");

      profileBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle("hidden");
      });

      document.addEventListener("click", () => {
        profileDropdown.classList.add("hidden");
      });

      document.getElementById("logoutBtn").addEventListener("click", () => {
        document.getElementById("logoutForm").submit();
      });

      // ===========================================================
      // Animasi angka statistik "hitung naik"
      // ===========================================================
      function animateCounter(el, target, options = {}) {
        if (!el) return;
        const duration = options.duration || 1600;
        const formatter = options.formatter || ((n) => n.toLocaleString("id-ID"));
        const startTime = performance.now();

        function tick(now) {
          const progress = Math.min((now - startTime) / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
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
        const statEls = [
          { el: document.getElementById("statTotalArsip") },
          { el: document.getElementById("statInstansi"), options: { formatter: (n) => n.toString() } },
          { el: document.getElementById("statTahunAwal"), options: { formatter: (n) => n.toString(), duration: 1200 } },
          { el: document.getElementById("statTahunAkhir"), options: { formatter: (n) => n.toString(), duration: 1200 } },
        ];
        statEls.forEach(({ el, options }) => {
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
          },
          { threshold: 0.4 },
        );
        statObserver.observe(statistikSection);
      } else {
        runStatCounters();
      }
    </script>
  </body>
</html>
