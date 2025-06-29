@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="left-side">
        <div>
            <img src="{{ asset('logo/logo.png') }}" style="max-width: 300px;" alt="Logo">
            <h1>Sistem Rekomendasi Negara</h1>
            <p>PT. Surya Eka Perkasa</p>
        </div>
    </div>

    <div class="right-side">
        <form method="POST" action="{{ route('login') }}" class="login-box">
            @csrf
            <h2>LOGIN</h2>

            <div class="form-group">
                <input type="email" name="email" placeholder="email" required autofocus>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="password" required>
            </div>

            <button type="submit">Login</button>

            @if (Route::has('register'))
                <a class="register-link" href="{{ route('register') }}">Register</a>
            @endif
        </form>
    </div>
</div>
@endsection
