@extends('layouts.guest')

@section('title', 'Atur Ulang Kata Sandi | LANDAKMAS')

@section('content')

<div class="w-full max-w-lg">
  <div class="bg-white rounded-3xl shadow-2xl p-10">
    <h1 class="font-serif text-4xl text-center text-slate-900">Atur Ulang Kata Sandi</h1>
    <p class="text-slate-500 text-center mt-4">
      Masukkan kata sandi baru untuk akun admin Anda.
    </p>

    @if ($errors->any())
      <div class="mt-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-5 py-4 text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form class="mt-10" method="POST" action="{{ route('admin.reset-password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-6">
        <label class="block text-sm text-slate-600 mb-2" for="email">Email</label>
        <input class="w-full rounded-xl bg-slate-50 border border-slate-200 px-5 py-4 outline-none focus:ring-2 focus:ring-secondary transition" id="email" name="email" type="email" value="{{ old('email', $email) }}" required autofocus>
      </div>

      <div class="mb-6">
        <label class="block text-sm text-slate-600 mb-2" for="password">Kata Sandi Baru</label>
        <input class="w-full rounded-xl bg-slate-50 border border-slate-200 px-5 py-4 outline-none focus:ring-2 focus:ring-secondary transition" id="password" name="password" type="password" minlength="8" required>
      </div>

      <div class="mb-2">
        <label class="block text-sm text-slate-600 mb-2" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
        <input class="w-full rounded-xl bg-slate-50 border border-slate-200 px-5 py-4 outline-none focus:ring-2 focus:ring-secondary transition" id="password_confirmation" name="password_confirmation" type="password" minlength="8" required>
      </div>

      <button class="w-full bg-primary text-white font-semibold rounded-xl py-4 mt-8 hover:bg-slate-800 transition" type="submit">
        Simpan Kata Sandi Baru
      </button>
    </form>

    <div class="text-center mt-8">
      <a class="inline-flex items-center gap-1 text-primary hover:underline" href="{{ route('admin.login') }}">
        Kembali ke Halaman Masuk
      </a>
    </div>
  </div>
</div>

@endsection
