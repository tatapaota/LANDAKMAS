@extends('layouts.guest')

@section('title', 'Masuk | LANDAKMAS')

@section('content')


<div class="w-full max-w-lg">
<!-- Banner error -->
<div class="{{ $errors->any() ? '' : 'hidden' }} bg-rose-100 border border-rose-200 text-rose-700 font-semibold text-center rounded-xl px-6 py-4 mb-6" id="errorBanner">
        {{ $errors->first() ?: 'Email atau kata sandi salah!' }}
      </div>
<!-- Card -->
<div class="bg-white rounded-3xl shadow-2xl p-10">
<h1 class="font-serif text-4xl text-center text-slate-900">Masuk</h1>
<p class="text-slate-500 text-center mt-4">
          Silakan masukkan email dan kata sandi Anda untuk melanjutkan.
        </p>
<form class="mt-10" id="loginForm" method="POST" action="{{ route('admin.login.attempt') }}">
@csrf
<div class="mb-6">
<label class="block text-sm text-slate-600 mb-2" for="email">Email</label>
<input autocomplete="username" class="w-full rounded-xl bg-slate-50 border border-slate-200 px-5 py-4 outline-none focus:ring-2 focus:ring-secondary transition {{ $errors->any() ? 'border-rose-400 ring-2 ring-rose-200' : '' }}" id="email" name="email" placeholder="nama@email.com" type="email" value="{{ old('email') }}"/>
</div>
<div class="mb-2">
<label class="block text-sm text-slate-600 mb-2" for="password">Kata Sandi</label>
<div class="relative">
<input autocomplete="current-password" class="w-full rounded-xl bg-slate-50 border border-slate-200 px-5 py-4 pr-14 outline-none focus:ring-2 focus:ring-secondary transition {{ $errors->any() ? 'border-rose-400 ring-2 ring-rose-200' : '' }}" id="password" name="password" placeholder="••••••••" type="password"/>
<button aria-label="Tampilkan kata sandi" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" id="togglePassword" type="button">
<svg class="w-6 h-6" fill="none" id="eyeIcon" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</button>
</div>
<div class="text-right mt-3">
<a class="text-sm text-secondary font-semibold hover:underline" href="{{ route('admin.forgot') }}">Lupa kata sandi?</a>
</div>
</div>
<button class="w-full bg-primary text-white font-semibold rounded-xl py-4 mt-8 hover:bg-slate-800 transition" id="submitBtn" type="submit">
            Masuk
          </button>
</form>
<div class="text-center mt-8">
<a class="inline-flex items-center gap-1 text-primary hover:underline" href="{{ route('admin.landing') }}">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M15.75 19.5L8.25 12l7.5-7.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
            Kembali ke Beranda
          </a>
</div>
</div>
</div>


<script>
      // Login sekarang diproses beneran di server (AuthController@login,
      // guard 'admin'), form ini POST biasa. Script di bawah cuma
      // urusan tampilan (toggle lihat/sembunyi kata sandi).
      const passwordInput = document.getElementById("password");

      document
        .getElementById("togglePassword")
        .addEventListener("click", () => {
          const isHidden = passwordInput.type === "password";
          passwordInput.type = isHidden ? "text" : "password";
        });
    </script>


@endsection
