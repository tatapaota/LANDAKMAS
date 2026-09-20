@extends('layouts.guest')

@section('title', 'Lupa Kata Sandi | LANDAKMAS')

@section('content')

<div class="w-full max-w-lg">
  <!-- Card form -->
  <div class="bg-white rounded-3xl shadow-2xl p-10" id="requestCard">
    <h1 class="font-serif text-4xl text-center text-slate-900">Lupa Kata Sandi</h1>
    <p class="text-slate-500 text-center mt-4">
      Masukkan email admin yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
    </p>

    <form class="mt-10" id="forgotForm">
      <div class="mb-2">
        <label class="block text-sm text-slate-600 mb-2" for="email">Email</label>
        <input autocomplete="username" class="w-full rounded-xl bg-slate-50 border border-slate-200 px-5 py-4 outline-none focus:ring-2 focus:ring-secondary transition" id="email" placeholder="nama@email.com" type="email" required />
      </div>

      <button class="w-full bg-primary text-white font-semibold rounded-xl py-4 mt-8 hover:bg-slate-800 transition" id="submitBtn" type="submit">
        Kirim Link Reset
      </button>
    </form>

    <div class="text-center mt-8">
      <a class="inline-flex items-center gap-1 text-primary hover:underline" href="{{ route('admin.login') }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.75 19.5L8.25 12l7.5-7.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        Kembali ke Halaman Masuk
      </a>
    </div>
  </div>

  <!-- Konfirmasi terkirim -->
  <div class="hidden bg-white rounded-3xl shadow-2xl p-10 text-center" id="successCard">
    <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M4.5 12.75l6 6 9-13.5" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
    </div>
    <h1 class="font-serif text-3xl text-slate-900 mt-6">Periksa Email Anda</h1>
    <p class="text-slate-500 mt-4">
      Jika <span class="font-semibold text-slate-700" id="sentToEmail"></span> terdaftar sebagai admin, kami sudah mengirimkan tautan untuk mengatur ulang kata sandi. Tautan berlaku selama 60 menit.
    </p>
    <a class="inline-block mt-8 bg-primary text-white font-semibold rounded-xl py-3 px-8 hover:bg-slate-800 transition" href="{{ route('admin.login') }}">
      Kembali ke Halaman Masuk
    </a>
  </div>
</div>

<script>
  // ============================================================
  // Kirim ke backend beneran (AuthController::sendResetLink), yang
  // akan mengirim email reset lewat AdminResetPasswordNotification
  // kalau email tersebut terdaftar sebagai admin.
  // ============================================================
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
  const forgotForm = document.getElementById("forgotForm");
  const requestCard = document.getElementById("requestCard");
  const successCard = document.getElementById("successCard");
  const submitBtn = document.getElementById("submitBtn");

  forgotForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const email = document.getElementById("email").value.trim();
    if (!email) return;

    submitBtn.disabled = true;
    submitBtn.textContent = "Mengirim...";

    fetch("{{ route('admin.forgot.send') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-CSRF-TOKEN": CSRF_TOKEN,
        },
        body: JSON.stringify({ email }),
      })
      .then(() => {
        document.getElementById("sentToEmail").textContent = email;
        requestCard.classList.add("hidden");
        successCard.classList.remove("hidden");
      })
      .catch(() => {
        document.getElementById("sentToEmail").textContent = email;
        requestCard.classList.add("hidden");
        successCard.classList.remove("hidden");
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = "Kirim Link Reset";
      });
  });
</script>

@endsection
