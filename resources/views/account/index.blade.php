@extends('layouts.main')
@section('title', 'Account')
@section('css')
<style>
    .myaccount-content-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #eef2f5;
        padding: 30px;
    }
    .myaccount-content-card h2 {
        color: #212121;
        font-weight: 700;
        margin-bottom: 20px;
        border-bottom: 2px solid #006bef;
        padding-bottom: 10px;
        font-size: 24px;
    }
    .welcome-box {
        background-color: #f0f7ff;
        border-left: 4px solid #006bef;
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 25px;
    }
    .welcome-box p {
        margin: 0;
        color: #333;
        font-size: 16px;
    }
    .welcome-box a.logout {
        color: #006bef;
        font-weight: 700;
        text-decoration: underline;
        margin-left: 5px;
    }
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        border-color: #006bef;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 107, 239, 0.15);
    }
    .stat-card i {
        font-size: 28px;
        color: #006bef;
        margin-bottom: 10px;
    }
    .stat-card h4 {
        font-size: 16px;
        font-weight: 700;
        color: #212121;
        margin-bottom: 5px;
    }
    .stat-card a {
        color: #006bef;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
    }
</style>
@endsection
@section('content')

<?php $segment = Request::segments(); ?>

<section class="banner inner-banner" style="background-image: url({{ asset('images/banner.png')}});">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li><img src="{{ asset('images/1-star.png') }}" alt="" ></li>
                    <li>
                        <div class="banner-content">
                            <div class="section-heading">
                                <h1 style="color: #006bef;">My Account</h1>
                            </div>
                        </div>
                    </li>
                    <li><img src="{{ asset('images/1-star.png') }}" alt=""></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<main class="my-cart py-5">
    <div class="my-account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            @include('account.sidebar')
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content-card">
                                    <h2>Dashboard</h2>
    
                                    <div class="welcome-box">
                                        <p>Hello, <strong>{{ Auth::user()->name }}</strong> (Not <strong>{{ Auth::user()->name }}</strong>? <a href="{{ url('signout') }}" class="logout">Logout</a>)</p>
                                    </div>
        
                                    <p class="text-muted">From your account dashboard, you can easily check and view your recent orders, manage your shipping/billing addresses, and edit your account details or password.</p>

                                    <div class="quick-stats">
                                        <div class="stat-card">
                                            <i class="fa fa-shopping-bag"></i>
                                            <h4>Orders</h4>
                                            <a href="{{ route('orders') }}">View Orders &rarr;</a>
                                        </div>
                                        <div class="stat-card">
                                            <i class="fa fa-user-edit"></i>
                                            <h4>Account Details</h4>
                                            <a href="{{ route('accountDetail') }}">Edit Details &rarr;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@section('js')
<script type="text/javascript">
     $(document).on('click', ".btn1", function(e){
            // alert('it works');
            $('.loginForm').submit();
     });
</script>
@endsection