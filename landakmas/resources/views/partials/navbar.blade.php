<nav class="bg-primary border-b border-slate-600">
<div class="max-w-7xl mx-auto">
<div class="flex items-center justify-between py-5 px-6">
<!-- Logo -->
<div class="flex items-center gap-4">
<img alt="Logo Banyumas" class="w-16 h-16 object-contain" src="{{ asset('assets/images/logo.png') }}"/>
<div>
<h1 class="text-white font-bold text-3xl">LANDAKMAS</h1>
<p class="text-slate-300 text-sm">
                Dinas Arsip dan Perpustakaan Daerah Kabupaten Banyumas
              </p>
</div>
</div>
<!-- Menu -->
<div class="hidden lg:flex items-center gap-14">
<a class="{{ request()->routeIs('home') ? 'text-blue-300 font-semibold' : 'text-slate-300 hover:text-blue-300' }} transition" href="{{ route('home') }}">
              Beranda
            </a>
<a class="{{ request()->routeIs('archive') ? 'text-blue-300 font-semibold' : 'text-slate-300 hover:text-blue-300' }} transition" href="{{ route('archive') }}">
              Cari Arsip
            </a>
<a class="{{ request()->routeIs('institution*') ? 'text-blue-300 font-semibold' : 'text-slate-300 hover:text-blue-300' }} transition" href="{{ route('institution') }}">
              Instansi
            </a>
<a class="{{ request()->routeIs('booking') ? 'text-blue-300 font-semibold' : 'text-slate-300 hover:text-blue-300' }} transition" href="{{ route('booking') }}">
              Permintaan Arsip
            </a>
</div>
</div>
</div>
</nav>