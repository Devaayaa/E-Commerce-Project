<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TokoKu')</title>
    
    <x-layout.css />
    @stack('styles')
</head>
<body class="min-h-screen text-slate-800 pt-28">

    <!-- Background Bersih -->
    <div class="bg-grid"></div>
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>

    <!-- Header Kaca -->
    <x-layout.header />

    <!-- Konten -->
    <main>
        @yield('content')
    </main>

    <x-layout.footer />
    <x-layout.js />
    @stack('scripts')
</body>
</html>