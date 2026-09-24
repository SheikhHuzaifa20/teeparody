@extends('layouts.main')
@section('title', 'Account Details')
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
    .single-input-item {
        margin-bottom: 20px;
    }
    .single-input-item label {
        font-weight: 600;
        color: #212121;
        margin-bottom: 8px;
        display: block;
    }
    .single-input-item input {
        width: 100%;
        height: 50px;
        border: 1px solid #006bef;
        border-radius: 8px;
        padding: 0 15px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    .single-input-item input:focus {
        outline: none;
        border-color: #0056c6;
        box-shadow: 0 0 0 3px rgba(0, 107, 239, 0.15);
    }
    fieldset {
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        background-color: #fafbfc;
    }
    fieldset legend {
        font-size: 16px;
        font-weight: 700;
        color: #006bef;
        width: auto;
        padding: 0 10px;
        float: none;
        margin: 0;
    }
    .btn-save-account {
        background-color: #006bef;
        color: #ffffff;
        border: none;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-save-account:hover {
        background-color: #0056c6;
        box-shadow: 0 4px 12px rgba(0, 107, 239, 0.3);
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
                                <h1 style="color: #006bef;">Account Details</h1>
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
                                    <h2>Account Details</h2>

                                    @if(Session::has('message'))
                                        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                                            {{ Session::get('message') }}
                                        </div>
                                    @endif
                                    @if(Session::has('flash_message'))
                                        <div class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismissible fade show" role="alert">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('update.account') }}" method="post" enctype="multipart/form-data" id="accountForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="single-input-item">
                                                    <label for="name" class="required">Full Name</label>
                                                    <input type="text" id="name" name="name" placeholder="Full Name" value="{{ Auth::user()->name }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-input-item">
                                            <label for="email" class="required">Email Address</label>
                                            <input type="email" id="email" placeholder="Email Address" name="email" value="{{ Auth::user()->email }}" required>
                                        </div>

                                        <fieldset>
                                            <legend><i class="fa fa-lock mr-1"></i> Change Password</legend>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="new-pwd">New Password</label>
                                                        <input type="password" id="new-pwd" placeholder="New Password" name="password">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="confirm-pwd">Confirm Password</label>
                                                        <input type="password" id="confirm-pwd" placeholder="Confirm Password" name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="single-input-item mt-3">
                                            <button type="submit" class="btn-save-account" id="updateProfile">Save Changes</button>
                                        </div>
                                    </form>
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
@section('css')
<style type="text/css">
    
</style>
@endsection
@section('js')

<script type="text/javascript">

 $(document).on('click', "#updateProfile", function(e){
        $('#accountForm').submit();
  });

</script>

@endsection