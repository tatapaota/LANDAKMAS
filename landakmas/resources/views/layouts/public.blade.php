<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>@yield('title', 'LANDAKMAS | Dinas Arsip Kabupaten Banyumas')</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

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

<body class="bg-white font-sans text-slate-800">
  <script src="{{ asset('js/keranjang.js') }}"></script>

  @include('partials.navbar')

  @yield('content')

  @include('partials.footer')

  @stack('scripts')
</body>

</html>