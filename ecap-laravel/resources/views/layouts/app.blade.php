<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECAP</title>
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    @stack('styles')
</head>
<body>
<header>
    <div class="headerbody">
        <a href="{{ route('home') }}" target="_parent"><img src="/images/logo-land.png" alt="logo"></a>
        <div class="buttons">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="button">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="button" style="background:none;border:none;cursor:pointer;padding:0;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="button">Login</a>
            @endauth
            <a href="{{ route('about') }}" class="button">About</a>
            <a href="{{ route('contact') }}" class="button">Contact Us</a>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer>
    <div class="footerbody">
        <div>
            Made in ♥ with Eco Creations and Products
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
