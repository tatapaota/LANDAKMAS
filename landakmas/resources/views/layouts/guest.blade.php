<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Masuk | LANDAKMAS')</title>

    <script src="https://cdn.tailwindcss.com"></script>

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

    @stack('head')
  </head>

  <body class="bg-primary font-sans text-slate-800 min-h-screen flex items-center justify-center px-4 py-12">
    @yield('content')

    @stack('scripts')
  </body>
</html>
