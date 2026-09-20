@extends('layouts.admin')

@section('title', 'Kelola Akun | LANDAKMAS')

@section('content')


<h2 class="font-serif text-4xl text-slate-900">Kelola Akun</h2>


<p class="text-slate-500 mt-2">
  Perbarui informasi akun kamu (nama, email, dan password) dengan aman.
</p>


<div class="grid lg:grid-cols-2 gap-6 mt-8 items-start">
  <!-- ===================== KIRI ===================== -->
  <div class="space-y-6">
    <!-- Informasi Akun -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
      <div class="bg-[#3E6C9E] px-6 py-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <h3 class="text-white font-semibold text-lg">Informasi Akun</h3>
      </div>
      <div class="p-6">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-semibold text-xl shrink-0">
            A
          </div>
          <div>
            <p class="font-semibold text-slate-800 text-lg" id="acc-name">
              {{ $admin->nama }}
            </p>
            <div class="flex flex-wrap gap-2 mt-2">
              <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 text-xs px-3 py-1.5 rounded-full">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span id="acc-email">{{ $admin->email }}</span>
              </span>
              <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 text-xs px-3 py-1.5 rounded-full">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Adminarsip
              </span>
            </div>
          </div>
        </div>
        <div class="bg-slate-50 rounded-xl p-5 mt-6">
          <p class="flex items-center gap-2 font-semibold text-slate-700 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Tips keamanan
          </p>
          <ul class="list-disc list-inside text-sm text-slate-600 mt-3 space-y-1.5">
            <li>
              Gunakan password minimal 8 karakter (lebih aman 12+).
            </li>
            <li>Hindari password yang sama dengan akun lain.</li>
            <li>
              Jika pernah login di perangkat umum, disarankan ganti
              password.
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Tambah Admin Baru (hanya terlihat oleh akun utama) -->
    @if ($isSuperAdmin)
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
      <div class="bg-[#3E6C9E] px-6 py-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <h3 class="text-white font-semibold text-lg">
          Tambah Admin Baru
        </h3>
      </div>
      <form class="p-6 space-y-5" id="addAdminForm" method="POST" action="{{ route('admin.account.storeAdmin') }}">
        @csrf
        <div>
          <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Nama Admin
          </label>
          <input class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm @error('new_admin_nama') border-rose-400 ring-2 ring-rose-200 @enderror" id="newAdminNama" name="new_admin_nama" placeholder="cth. Budi Santoso" type="text" value="{{ old('new_admin_nama') }}" />
        </div>
        <div>
          <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Email / Akun
          </label>
          <input class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm @error('new_admin_email') border-rose-400 ring-2 ring-rose-200 @enderror" id="newAdminEmail" name="new_admin_email" placeholder="nama@ac.id" type="email" value="{{ old('new_admin_email') }}" />
        </div>
        <div>
          <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Password Awal
          </label>
          <div class="relative">
            <input class="w-full px-4 py-3 pr-11 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm @error('new_admin_password') border-rose-400 ring-2 ring-rose-200 @enderror" id="newAdminPassword" name="new_admin_password" placeholder="Minimal 8 karakter" type="password" />
            <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" onclick="togglePasswordField('newAdminPassword', this)" type="button">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </button>
          </div>
          <p class="text-xs text-slate-400 mt-2">
            Admin baru bisa mengganti password ini setelah login pertama
            kali.
          </p>
        </div>
        <button class="w-full sm:w-auto bg-primary text-white font-semibold px-6 py-3 rounded-xl hover:bg-slate-800 transition" type="submit">
          + Tambah Admin
        </button>
        @if ($errors->hasAny(['new_admin_nama', 'new_admin_email', 'new_admin_password']))
        <p class="text-rose-500 text-sm font-medium" id="addAdminError">
          {{ $errors->first('new_admin_nama') ?: ($errors->first('new_admin_email') ?: $errors->first('new_admin_password')) }}
        </p>
        @else
        <p class="hidden text-rose-500 text-sm font-medium" id="addAdminError">
          Lengkapi nama, email, dan password terlebih dahulu.
        </p>
        @endif
      </form>
    </div>
    @endif
    @if ($isSuperAdmin)
    <!-- Daftar Akun Admin (hanya terlihat oleh akun utama) -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
      <div class="bg-[#3E6C9E] px-6 py-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <h3 class="text-white font-semibold text-lg">Daftar Akun Admin</h3>
      </div>
      <div class="p-6">
        <p class="text-slate-500 text-sm mb-5">
          Sebagai akun utama, kamu bisa melihat dan menghapus akun admin
          lain. Admin selain akun utama tidak bisa melihat daftar ini.
        </p>
        <div class="space-y-3">
          @foreach ($admins as $item)
          <div class="flex items-center justify-between gap-4 bg-slate-50 rounded-xl px-4 py-3">
            <div class="min-w-0">
              <p class="font-semibold text-slate-800 text-sm truncate">
                {{ $item->nama }}
                @if ($item->id === $admin->id)
                <span class="text-xs font-normal text-slate-400">(kamu)</span>
                @endif
                @if ($item->isSuperAdmin())
                <span class="inline-flex items-center bg-amber-100 text-amber-700 text-[11px] font-medium px-2 py-0.5 rounded-full ml-1">Akun Utama</span>
                @endif
              </p>
              <p class="text-slate-500 text-xs truncate">{{ $item->email }}</p>
            </div>
            @if (! $item->isSuperAdmin() && $item->id !== $admin->id)
            <form action="{{ route('admin.account.destroyAdmin', $item) }}" method="POST" onsubmit="return confirm('Hapus akun &quot;{{ $item->nama }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
              @csrf
              @method('DELETE')
              <button class="shrink-0 inline-flex items-center gap-1.5 text-rose-500 hover:text-rose-600 text-sm font-medium" type="submit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Hapus
              </button>
            </form>
            @endif
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
  </div>
  <!-- ===================== KANAN: Pengaturan Akun ===================== -->
  <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="bg-[#3E6C9E] px-6 py-4 flex items-center gap-3">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.213-1.281z" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
      <h3 class="text-white font-semibold text-lg">Pengaturan Akun</h3>
    </div>
    <form class="p-8" id="settingsForm" method="POST" action="{{ route('admin.account.update') }}">
      @csrf
      @method('PUT')
      <div class="grid sm:grid-cols-2 gap-x-8 gap-y-6">
        <div>
          <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Nama
          </label>
          <input class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm @error('nama') border-rose-400 ring-2 ring-rose-200 @enderror" name="nama" placeholder="Admin" type="text" value="{{ old('nama', $admin->nama) }}" />
          @error('nama')
          <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
          @else
          <p class="text-xs text-slate-400 mt-2">
            Nama yang tampil di sistem.
          </p>
          @enderror
        </div>
        <div>
          <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Email / Akun
          </label>
          <input class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm @error('email') border-rose-400 ring-2 ring-rose-200 @enderror" name="email" placeholder="admin@ac.id" type="email" value="{{ old('email', $admin->email) }}" />
          @error('email')
          <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
          @else
          <p class="text-xs text-slate-400 mt-2">
            Email ini dipakai untuk login.
          </p>
          @enderror
        </div>
      </div>
      <div class="border-b border-slate-200 my-7"></div>
      <div>
        <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          Password Saat Ini
        </label>
        <div class="relative">
          <input class="w-full px-4 py-3 pr-11 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm @error('current_password') border-rose-400 ring-2 ring-rose-200 @enderror" id="currentPasswordInput" name="current_password" placeholder="Wajib jika ingin mengganti password" type="password" />
          <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" onclick="togglePasswordField('currentPasswordInput', this)" type="button">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" stroke-linecap="round" stroke-linejoin="round"></path>
              <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </button>
        </div>
        @error('current_password')
        <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
        @else
        <p class="text-xs text-slate-400 mt-2">
          Kosongkan jika tidak mengganti password.
        </p>
        @enderror
      </div>
      <div class="grid sm:grid-cols-2 gap-x-8 gap-y-6 mt-6">
        <div>
          <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Password Baru
          </label>
          <div class="relative">
            <input class="w-full px-4 py-3 pr-11 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm @error('password') border-rose-400 ring-2 ring-rose-200 @enderror" id="newPasswordInput" name="password" placeholder="Password Baru" type="password" />
            <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" onclick="togglePasswordField('newPasswordInput', this)" type="button">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </button>
          </div>
          @error('password')
          <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
          @else
          <p class="text-xs text-slate-400 mt-2">Minimal 8 karakter.</p>
          @enderror
        </div>
        <div>
          <label class="flex items-center gap-1.5 text-sm text-slate-500 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Konfirmasi Password
          </label>
          <div class="relative">
            <input class="w-full px-4 py-3 pr-11 rounded-lg bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-secondary/30 placeholder:text-slate-400 text-sm" id="confirmPasswordInput" name="password_confirmation" placeholder="Konfirmasi Password" type="password" />
            <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" onclick="
                        togglePasswordField('confirmPasswordInput', this)
                      " type="button">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </button>
          </div>
          <p class="text-xs text-slate-400 mt-2">
            Harus sama dengan password baru.
          </p>
        </div>
      </div>
      <div class="flex justify-end mt-8">
        <button class="bg-emerald-500 text-white font-semibold px-7 py-3 rounded-xl hover:bg-emerald-600 transition" type="submit">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>


<div class="{{ session('newAdminEmail') ? '' : 'hidden' }} fixed inset-0 z-50 bg-slate-400/30 backdrop-blur-sm overflow-y-auto" id="successOverlay">
  <div class="max-w-4xl mx-auto px-6 py-10">
    <button class="flex items-center gap-2 bg-primary text-white font-semibold text-lg mb-6 px-4 py-2 rounded-xl shadow-md hover:bg-slate-800 transition" onclick="closeSuccessModal()">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
      Kembali
    </button>
    <div class="bg-white rounded-3xl shadow-2xl p-8">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
        </div>
        <h3 class="font-serif text-2xl text-slate-900">
          Akun Berhasil Dibuat
        </h3>
      </div>
      <p class="text-slate-500 text-sm mb-4">
        Admin baru sudah bisa login menggunakan akun berikut.
      </p>
      <div class="border-b border-slate-200 mb-6"></div>
      <div class="grid sm:grid-cols-2 gap-6">
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">Nama</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5" id="successNama">{{ session('newAdminNama') }}</p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">Email / Akun</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5" id="successEmail">{{ session('newAdminEmail') }}</p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">Password Awal</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5">
              ••••••••
            </p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
          <div>
            <p class="text-slate-400 text-sm">Status Akun</p>
            <p class="font-semibold text-slate-800 text-lg mt-0.5">Aktif</p>
          </div>
        </div>
      </div>
      <div class="border-b border-slate-200 my-8"></div>
      <h3 class="font-serif text-xl text-slate-900 mb-4">Catatan</h3>
      <div class="bg-slate-50 rounded-xl p-5 text-slate-600 leading-7">
        Sarankan admin baru untuk mengganti password setelah berhasil login
        pertama kali, demi keamanan akun.
      </div>
    </div>
  </div>
</div>


<script>
  function togglePasswordField(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
  }

  // Kedua form di atas sekarang benar-benar POST/PUT ke server
  // (AccountController@update dan @storeAdmin), jadi tidak perlu lagi
  // simulasi submit + alert di sini. Validasi form kosong ditangani
  // otomatis lewat validasi Laravel (pesan error muncul di atas field).
  function closeSuccessModal() {
    document.getElementById("successOverlay").classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
  }

  @if (session('newAdminEmail'))
  document.body.classList.add("overflow-hidden");
  @endif
</script>


@endsection