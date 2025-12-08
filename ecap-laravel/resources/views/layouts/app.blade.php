<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECAP</title>
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@include('partials.loader')
<header>
    <div class="headerbody">
        <a href="{{ route('home') }}" target="_parent"><img src="/images/logo-land.png" alt="logo"></a>
        <button class="hamburger" aria-label="Open navigation" aria-expanded="false">☰</button>
        <nav class="buttons">
            <a href="{{ route('about') }}" class="button">About</a>
            <a href="{{ route('contact') }}" class="button">Contact Us</a>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="button">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="button">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="button">Login</a>
            @endauth
        </nav>
    </div>
</header>

<aside class="mobile-sidebar" aria-hidden="true">
    <div class="mobile-sidebar-inner">
        <button class="mobile-close" aria-label="Close navigation">×</button>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            @auth
                @if(auth()->user()->is_admin)
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="link-button">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
            @endauth
        </ul>
    </div>
</aside>

<main>
    @yield('content')
    {{-- support Blade component slot (e.g. <x-app-layout>) --}}
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
