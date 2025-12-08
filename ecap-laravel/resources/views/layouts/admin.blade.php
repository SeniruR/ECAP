<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - ECAP</title>
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="admin-body">
@include('partials.loader')
<header>
    <div class="headerbody">
        <a href="{{ route('home') }}" target="_parent"><img src="/images/logo-land.png" alt="logo"></a>
        <button class="hamburger" aria-label="Open navigation" aria-expanded="false">☰</button>
        <nav class="buttons">
            <a href="{{ route('home') }}" class="button">Home</a>
            <a href="{{ route('admin.dashboard') }}" class="button">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="button">Logout</button>
            </form>
        </nav>
    </div>
</header>

<aside class="mobile-sidebar" aria-hidden="true">
    <div class="mobile-sidebar-inner">
        <button class="mobile-close" aria-label="Close navigation">×</button>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link-button">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</aside>

<main>
    @yield('content')
    @isset($slot)
        {{ $slot }}
    @endisset
</main>

<footer>
    <div class="footerbody">
        <div>
            Made in ♥ with Eco Creations and Products
        </div>
    </div>
</footer>

    <script src="/js/adm/admin-actions.js" defer></script>
    <script src="/js/ui.js" defer></script>
    <script src="/js/lazyload.js" defer></script>
@stack('scripts')
</body>
</html>
