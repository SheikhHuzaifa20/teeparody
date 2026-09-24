@extends('layouts.main')
@section('title', 'Sign Up')
@section('css')
<style>
    .auth-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 107, 239, 0.08);
        border: 1px solid #eef2f5;
        padding: 40px;
        margin: 0 auto;
        max-width: 480px;
    }
    .auth-card h2 {
        color: #212121;
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 26px;
        text-align: center;
    }
    .auth-card .form-group {
        margin-bottom: 20px;
    }
    .auth-card label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }
    .auth-card .form-control {
        height: 50px;
        border: 1px solid #006bef;
        border-radius: 8px;
        padding: 0 16px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    .auth-card .form-control:focus {
        border-color: #0056c6;
        box-shadow: 0 0 0 3px rgba(0, 107, 239, 0.15);
    }
    .btn-auth-primary {
        background-color: #006bef;
        color: #ffffff;
        height: 50px;
        width: 100%;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 700;
        transition: all 0.3s ease;
        cursor: pointer;
        display: block;
    }
    .btn-auth-primary:hover {
        background-color: #0056c6;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 107, 239, 0.3);
    }
    .auth-links {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        font-size: 14px;
    }
    .auth-links a {
        color: #006bef;
        font-weight: 600;
        text-decoration: none;
    }
    .auth-links a:hover {
        text-decoration: underline;
    }
</style>
@endsection
@section('content')
<section class="banner inner-banner" style="background-image: url({{ asset('images/banner.png')}});">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li><img src="{{ asset('images/1-star.png') }}" alt="" ></li>
                    <li>
                        <div class="banner-content">
                            <div class="section-heading">
                                <h1 style="color: #006bef;">Register Account</h1>
                            </div>
                        </div>
                    </li>
                    <li><img src="{{ asset('images/1-star.png') }}" alt=""></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="account py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <h2>Create Account</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Full Name*</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                            @if ($errors->has('name'))
                            <small class="text-danger d-block mt-1">{{ $errors->first('name') }}</small>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label>Email Address*</label>
                            <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                            @if ($errors->has('email'))
                            <small class="text-danger d-block mt-1">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label>Password*</label>
                            <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Create a password" required>
                            @if ($errors->has('password'))
                            <small class="text-danger d-block mt-1">{{ $errors->first('password') }}</small>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label>Confirm Password*</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                        </div>
                        <button class="btn-auth-primary mt-3" type="submit">Create Account</button>
                        <div class="auth-links mt-4">
                            <span class="text-muted">Already have an account?</span>
                            <a href="{{ route('signin') }}" class="ms-2">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
@endsection
