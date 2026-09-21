@extends('layouts.public')

@section('title', 'Permintaan Arsip | LANDAKMAS')

@section('content')



<section class="bg-primary">
  <div class="max-w-7xl mx-auto px-6 py-16 text-center">
    <h1 class="font-serif text-white text-5xl leading-tight">
      Permintaan Arsip
    </h1>
    <p class="text-slate-300 mt-5 max-w-2xl mx-auto leading-8">
      Lengkapi data diri di bawah ini untuk menyelesaikan permintaan arsip
      yang sudah Anda booking.
      <strong class="text-white font-semibold">Peminjam wajib datang langsung ke Kantor Dinas Arsip dan
        Perpustakaan Daerah Kabupaten Banyumas</strong>
      (Jl. Jenderal Gatot Subroto, Purwokerto) pada hari kerja untuk
      verifikasi identitas dan pengambilan dokumen.
    </p>
  </div>
</section>


<section class="bg-[#F8FAFC] py-20">
  <div class="max-w-4xl mx-auto px-6">
    <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-12">
      <!-- ============================
               RINGKASAN ARSIP DI KERANJANG
          ============================= -->
      <div class="mb-10">
        <small class="uppercase tracking-widest text-slate-500">
          Keranjang Permintaan
        </small>
        <h2 class="font-serif text-3xl mt-2 text-slate-900">
          Arsip yang Anda Booking
        </h2>
        <div class="mt-6 space-y-3" id="keranjangList">
          <!-- Diisi otomatis oleh JavaScript -->
        </div>
        <!-- Ditampilkan kalau keranjang kosong -->
        <div class="hidden mt-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl px-6 py-5" id="keranjangKosong">
          <p class="font-semibold">Belum ada arsip yang dibooking.</p>
          <p class="text-sm mt-1">
            Silakan cari dan booking arsip terlebih dahulu di halaman
            <a class="underline font-medium" href="{{ route('archive') }}">Cari Arsip</a>
            sebelum mengisi data peminjam.
          </p>
        </div>
      </div>
      <div class="border-t border-slate-100 mb-10"></div>
      <!-- ============================
               FORM DATA PEMINJAM
          ============================= -->
      <div class="mb-8">
        <small class="uppercase tracking-widest text-slate-500">
          Formulir
        </small>
        <h2 class="font-serif text-3xl mt-2 text-slate-900">
          Data Peminjam
        </h2>
        <p class="text-slate-500 mt-2">
          Lengkapi seluruh data di bawah ini dengan benar. Kolom bertanda
          <span class="text-rose-500">*</span> wajib diisi.
        </p>
      </div>
      <form class="space-y-8" id="requestForm">
        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Nama Lengkap <span class="text-rose-500">*</span>
            </label>
            <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition" name="nama" id="namaInput" placeholder="Masukkan nama lengkap" required="" type="text" pattern="[A-Za-zÀ-ÿ\s]+" title="Nama hanya boleh diisi huruf dan spasi" autocomplete="name" />
            <p class="text-xs text-slate-500 mt-2">Hanya huruf dan spasi (tanpa angka atau simbol).</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Nomor Telepon <span class="text-rose-500">*</span>
            </label>
            <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition" name="telepon" id="teleponInput" placeholder="08xxxxxxxxxx" required="" type="tel" inputmode="numeric" pattern="[0-9]{12,15}" minlength="12" maxlength="15" title="Nomor telepon hanya angka, 12-15 digit" autocomplete="tel" />
            <p class="text-xs text-slate-500 mt-2">Hanya angka, minimal 12 dan maksimal 15 digit.</p>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Alamat <span class="text-rose-500">*</span>
            </label>
            <textarea class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition resize-none" name="alamat" placeholder="Masukkan alamat lengkap" required="" rows="3"></textarea>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Email <span class="text-rose-500">*</span>
            </label>
            <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition" name="email" id="emailInput" placeholder="nama@email.com" required="" type="email" autocomplete="email" />
            <p class="text-xs text-slate-500 mt-2">
              Gunakan email aktif yang benar-benar terdaftar resmi (mis. Gmail), bukan email asal/palsu — balasan admin akan dikirim ke alamat ini.
            </p>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Tujuan Permintaan Arsip <span class="text-rose-500">*</span>
            </label>
            <textarea class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition resize-none" name="tujuan" placeholder="Jelaskan tujuan penggunaan arsip yang diminta" required="" rows="4"></textarea>
          </div>
          <!-- Jam Layanan -->
          <div class="md:col-span-2">
            <div class="bg-blue-50 border border-blue-100 rounded-2xl px-6 py-6">
              <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 6v6l4 2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round"></circle>
                </svg>
                <p class="font-semibold text-primary text-sm uppercase tracking-wide">Jam Layanan</p>
              </div>

              <div class="mt-4 max-w-xs mx-auto divide-y divide-blue-100">
                <div class="flex items-center justify-between py-2.5">
                  <span class="flex items-center gap-2 text-sm text-slate-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Senin - Kamis
                  </span>
                  <span class="text-sm font-semibold text-slate-800">07.30 - 14.30</span>
                </div>
                <div class="flex items-center justify-between py-2.5">
                  <span class="flex items-center gap-2 text-sm text-slate-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Jumat
                  </span>
                  <span class="text-sm font-semibold text-slate-800">07.30 - 14.30</span>
                </div>
                <div class="flex items-center justify-between py-2.5">
                  <span class="flex items-center gap-2 text-sm text-slate-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                    Sabtu - Minggu
                  </span>
                  <span class="text-sm font-semibold text-rose-500">Tutup</span>
                </div>
              </div>
            </div>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Tanggal Pengambilan Arsip <span class="text-rose-500">*</span>
            </label>
            <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition" id="tanggalPengambilanInput" name="tanggal_pengambilan" required="" type="date" min="{{ now()->toDateString() }}" />
            <p class="text-xs text-slate-500 mt-2">
              Pilih tanggal Anda akan datang langsung ke Kantor Dinas Arsip
              dan Perpustakaan Daerah Kabupaten Banyumas untuk verifikasi dan
              pengambilan dokumen (hari kerja).
            </p>
          </div>
        </div>
        <!-- Submit -->
        <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
          <button class="w-full sm:w-auto bg-secondary text-white px-10 py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn" type="submit">
            Kirim Permintaan
          </button>
        </div>
      </form>
      <!-- Pesan Gagal -->
      <div class="hidden mt-8 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl px-6 py-5" id="errorMessage">
        <p class="font-semibold">Permintaan arsip gagal dikirim.</p>
        <p class="text-sm mt-1" id="errorMessageText">
          Terjadi kesalahan di server. Silakan coba lagi beberapa saat lagi.
        </p>
      </div>
      <!-- Pesan Sukses -->
      <div class="hidden mt-8 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-6 py-5" id="successMessage">
        <p class="font-semibold">Permintaan arsip berhasil diajukan.</p>
        <p class="text-sm mt-1">
         Pengambilan dokumen dapat dilakukan setelah memperoleh konfirmasi dari admin melalui email.
        </p>
        <p class="text-sm mt-2 font-medium">
          Mohon memeriksa email secara berkala untuk mendapatkan informasi lebih lanjut terkait jadwal pengambilan.
        </p>
      </div>
    </div>
  </div>
</section>



<script>
  // Pengaman: kalau keranjang.js gagal dimuat, buat fungsi kosong
  // supaya halaman ini tetap tampil (hanya menampilkan keranjang kosong)
  // alih-alih error dan blank.
  if (typeof getKeranjang !== "function") {
    console.warn(
      "keranjang.js tidak termuat. Pastikan file tersebut ada satu folder dengan booking_arsip.html.",
    );
    window.KERANJANG_KEY = "ardarika_keranjang";
    window.BOOKING_LOCK_KEY = "ardarika_booking_lock";
    window.getKeranjang = () => [];
    window.removeFromKeranjang = () => {};
    window.clearKeranjang = () => {};
  }

  const keranjangList = document.getElementById("keranjangList");
  const keranjangKosong = document.getElementById("keranjangKosong");
  const submitBtn = document.getElementById("submitBtn");
  const requestForm = document.getElementById("requestForm");
  const successMessage = document.getElementById("successMessage");
  const errorMessage = document.getElementById("errorMessage");
  const tanggalPengambilanInput = document.getElementById(
    "tanggalPengambilanInput",
  );
  const namaInput = document.getElementById("namaInput");
  const teleponInput = document.getElementById("teleponInput");
  const emailInput = document.getElementById("emailInput");
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

  // ===== Filter input real-time =====
  // Nama: buang semua karakter selain huruf & spasi saat diketik.
  if (namaInput) {
    namaInput.addEventListener("input", () => {
      namaInput.value = namaInput.value.replace(/[^A-Za-zÀ-ÿ\s]/g, "");
    });
  }

  // Nomor telepon: buang semua karakter selain angka, batasi maksimal 15 digit.
  if (teleponInput) {
    teleponInput.addEventListener("input", () => {
      teleponInput.value = teleponInput.value.replace(/\D/g, "").slice(0, 15);
    });
  }

  // Validasi ringan di sisi browser sebelum data dikirim ke server.
  // Validasi final & yang sesungguhnya tetap dilakukan di server
  // (lihat PublicSiteController::bookingStore()).
  function validasiFormSisiClient() {
    const namaVal = namaInput ? namaInput.value.trim() : "";
    const teleponVal = teleponInput ? teleponInput.value.trim() : "";
    const emailVal = emailInput ? emailInput.value.trim() : "";

    if (!/^[A-Za-zÀ-ÿ\s]+$/.test(namaVal)) {
      return "Nama lengkap hanya boleh diisi huruf dan spasi.";
    }
    if (!/^[0-9]{12,15}$/.test(teleponVal)) {
      return "Nomor telepon wajib angka saja, minimal 12 dan maksimal 15 digit.";
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
      return "Masukkan alamat email yang valid dan aktif (bukan email asal/palsu).";
    }
    return null;
  }


  // Tanggal pengambilan minimal hari ini (tidak bisa pilih tanggal yang
  // sudah lewat), peminjam boleh datang di hari yang sama (hari-H).
  if (tanggalPengambilanInput) {
    const hariIni = new Date();
    tanggalPengambilanInput.min = hariIni.toISOString().slice(0, 10);
  }

  // Data booking sekarang dikirim langsung ke server (lihat handler
  // "submit" di bawah) dan disimpan di tabel booking_requests, jadi
  // tidak perlu lagi disalin ke localStorage supaya muncul di admin.

  function renderKeranjang() {
    const items = getKeranjang();

    if (items.length === 0) {
      keranjangList.innerHTML = "";
      keranjangKosong.classList.remove("hidden");
      submitBtn.disabled = true;
      return;
    }

    keranjangKosong.classList.add("hidden");
    submitBtn.disabled = false;

    keranjangList.innerHTML = items
      .map(
        (item) => `
              <div class="flex flex-col sm:flex-row sm:items-start gap-5 bg-slate-50 border border-slate-200 rounded-2xl px-6 py-6">
                <!-- Ikon dokumen -->
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-secondary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 21V8.25a2.25 2.25 0 00-.659-1.591l-4.5-4.5A2.25 2.25 0 0012.75 1.5H6A2.25 2.25 0 003.75 3.75v16.5A2.25 2.25 0 006 22.5h11.25A2.25 2.25 0 0019.5 21z" />
                  </svg>
                </div>

                <!-- Detail arsip -->
                <div class="flex-1 min-w-0">
                  <div class="flex flex-wrap items-center gap-x-2 gap-y-1.5 text-sm">
                    <span class="font-semibold text-slate-800">Kode Klasifikasi:</span>
                    <span class="bg-slate-200 text-slate-700 px-2 py-0.5 rounded-md font-medium">${item.kode}</span>
                    <span class="font-semibold text-slate-800 ml-2">Instansi:</span>
                    <span class="text-slate-600">${item.instansi}</span>
                    <span class="font-semibold text-slate-800 ml-2">Tahun:</span>
                    <span class="text-slate-600">${item.tahun}</span>
                  </div>

                  <p class="font-semibold text-slate-800 mt-4">Uraian:</p>
                  <p class="text-slate-600 mt-1 leading-7">${item.uraian}</p>
                </div>

                <!-- Tombol hapus -->
                <button
                  type="button"
                  onclick="handleRemove('${item.id}')"
                  class="self-start flex-shrink-0 text-xs font-semibold text-rose-500 border border-rose-200 bg-rose-50 px-3 py-1.5 rounded-lg hover:bg-rose-100 transition whitespace-nowrap"
                >
                  Hapus
                </button>
              </div>
            `,
      )
      .join("");
  }

  function handleRemove(arsipId) {
    removeFromKeranjang(arsipId);
    renderKeranjang();
  }

  // Sinkron otomatis kalau keranjang berubah dari tab lain
  window.addEventListener("storage", (e) => {
    if (e.key === KERANJANG_KEY || e.key === BOOKING_LOCK_KEY) {
      renderKeranjang();
    }
  });

  renderKeranjang();

  requestForm.addEventListener("submit", function(e) {
    e.preventDefault();

    const items = getKeranjang();
    if (items.length === 0) return;

    errorMessage.classList.add("hidden");

    const validasiError = validasiFormSisiClient();
    if (validasiError) {
      document.getElementById("errorMessageText").textContent = validasiError;
      errorMessage.classList.remove("hidden");
      errorMessage.scrollIntoView({ behavior: "smooth", block: "center" });
      return;
    }

    const formData = new FormData(requestForm);
    const peminjam = Object.fromEntries(formData.entries());

    submitBtn.disabled = true;
    submitBtn.textContent = "Mengirim...";

    fetch("{{ route('booking.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-CSRF-TOKEN": CSRF_TOKEN,
        },
        body: JSON.stringify({
          nama: peminjam.nama,
          telepon: peminjam.telepon,
          email: peminjam.email,
          alamat: peminjam.alamat,
          tujuan: peminjam.tujuan,
          tanggal_pengambilan: peminjam.tanggal_pengambilan,
          arsip: items.map((item) => ({
            id: item.id,
            no: item.no,
            kode: item.kode,
            uraian: item.uraian,
            instansi: item.instansi,
            tahun: item.tahun,
          })),
        }),
      })
      .then(async (res) => {
        if (!res.ok) {
          const data = await res.json().catch(() => null);
          throw new Error(
            data?.message || "Gagal mengirim permintaan ke server.",
          );
        }
        return res.json();
      })
      .then(() => {
        // Kosongkan keranjang (kunci booking arsip tetap terjaga, arsip
        // yang sudah diproses tidak boleh dibooking ulang oleh orang lain)
        clearKeranjang();

        requestForm.reset();
        renderKeranjang();
        successMessage.classList.remove("hidden");
        successMessage.scrollIntoView({
          behavior: "smooth",
          block: "center",
        });
      })
      .catch((err) => {
        document.getElementById("errorMessageText").textContent =
          err.message || "Terjadi kesalahan di server. Silakan coba lagi beberapa saat lagi.";
        errorMessage.classList.remove("hidden");
        errorMessage.scrollIntoView({ behavior: "smooth", block: "center" });
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = "Kirim Permintaan";
      });
  });
</script>


@endsection