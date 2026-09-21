<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>@yield('title', 'LANDAKMAS Admin | Dinas Arsip Kabupaten Banyumas')</title>

  <!--
    Proteksi login halaman ini sekarang ditangani di server lewat
    middleware 'auth:admin' (lihat routes/web.php + bootstrap/app.php),
    bukan lagi lewat pengecekan sessionStorage di sisi klien.
  -->

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Chart.js (used on Dashboard) & SheetJS (used on Permintaan Booking export) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet" />

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

  @stack('head')
</head>

<body class="bg-soft font-sans text-slate-800">
  <div class="flex min-h-screen">
    @include('partials.admin_sidebar')

    <main class="flex-1 px-10 py-10">
      @if(session('status'))
      <div class="bg-emerald-50 text-emerald-700 text-sm font-medium rounded-xl px-5 py-4 mb-6">
        {{ session('status') }}
      </div>
      @endif
      @if(session('error'))
      <div class="bg-red-50 text-red-600 text-sm font-medium rounded-xl px-5 py-4 mb-6">
        {{ session('error') }}
      </div>
      @endif
      @yield('content')
    </main>
  </div>

  @stack('scripts')
</body>

</html>