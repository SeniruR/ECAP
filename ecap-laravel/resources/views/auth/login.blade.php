@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/forms.css">
@endpush

@section('content')
    <main class="form-page">
        <div class="form-container">
            <div class="form-card">
                <div class="left">
                    <h1>Welcome to ECAP</h1>
                    <p class="lead">Explore our range of eco-friendly products and join us in making the world a greener place. Log in to access your personalized experience.</p>
                </div>
                <div class="right">
                    <h2>Login</h2>
                    @if(session('status'))
                        <div class="alert">{{ session('status') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert">{{ session('error') }}</div>
                    @endif

                    <form name="login" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-field">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                            @error('email')<div style="color:red">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-field">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" placeholder="Enter your password" required>
                            @error('password')<div style="color:red">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-actions">
                            <a class="btn btn-ghost" href="{{ route('register') }}">Sign Up</a>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                        <p class="form-note"><a href="{{ route('password.request') }}">Forgot password?</a></p>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
