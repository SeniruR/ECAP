@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/loginformstyle.css">
@endpush

@section('content')
<body style="overflow:hidden;">
    <div class="main">
        <div class="main_box">
            <div class="leftside">
                <h1 style="color:rgb(34, 139, 34);">Welcome to ECAP</h1>
                <h3>Explore our range of eco-friendly products and join us in making the world a greener place.</h3>
                <h5>Log in to access your personalized shopping experience and start your journey towards a sustainable lifestyle.</h5>
            </div>
            <hr>
            <div class="rightside">
                <h2>Login</h2>

                @if(session('status'))
                    <p style="color: red; text-align: center; margin-top: 10px; margin-bottom:0px">{{ session('status') }}</p>
                @endif
                @if(session('error'))
                    <p style="color: red; text-align: center; margin-top: 10px; margin-bottom:0px">{{ session('error') }}</p>
                @endif

                <form name="login" method="POST" action="{{ route('login') }}">
                    @csrf
                    <table class="table">
                        <tr>
                            <td class="label-cell"><label for="email">Email</label></td>
                            <td class="input-cell">
                                <input id="email" type="email" name="email" placeholder="Enter your Email" value="{{ old('email') }}" required autofocus>
                                @error('email')<div style="color:red">{{ $message }}</div>@enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="password">Password</label></td>
                            <td class="input-cell">
                                <input id="password" type="password" name="password" placeholder="Enter your Password" required>
                                @error('password')<div style="color:red">{{ $message }}</div>@enderror
                            </td>
                        </tr>

                        <tr class="button">
                            <td colspan="2"><button type="submit">Login</button></td>
                        </tr>
                    </table>

                    <p>If you haven't signed up yet? <a href="{{ route('register') }}">Sign Up</a></p>
                    <p><a href="{{ route('password.request') }}">Forget Password</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
