@extends('layouts.main')
@section('title', 'Order')
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
    .table-orders thead {
        background-color: #006bef;
        color: #ffffff;
    }
    .table-orders thead th {
        border: none;
        padding: 14px;
        font-weight: 600;
        font-size: 15px;
    }
    .table-orders tbody td {
        vertical-align: middle;
        padding: 14px;
        font-size: 15px;
    }
    .btn-view-invoice {
        background-color: #006bef;
        color: #ffffff !important;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .btn-view-invoice:hover {
        background-color: #0056c6;
        box-shadow: 0 2px 8px rgba(0, 107, 239, 0.3);
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 12px;
        text-transform: capitalize;
    }
    .badge-pending { background-color: #fff3cd; color: #856404; }
    .badge-delivered { background-color: #d4edda; color: #155724; }
    .badge-in_process { background-color: #cce5ff; color: #004085; }
    .badge-canceled { background-color: #f8d7da; color: #721c24; }
    
    .banner-content {
    display: flex;
    justify-content: center;
}
</style>
@endsection
@section('content')

<?php $segment = Request::segments(); ?>

<section class="banner about-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="banner-content animate">
                    <h1><span class="blue">Order History</span>
                    </h1>
                    {{-- {!! $banner->description !!}
                    <a href="{{route('product')}}" class="btn web-btn">
                        Shop Now
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="banner-girl">
        <img src="{{asset('asset/images/banner-girl.png')}}" class="img-fluid" alt="">
    </div> --}}
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
                                    <h2>Order History</h2>

                                    <div class="table-responsive text-center">
                                        <table class="table table-bordered table-orders align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Invoice No</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($ORDERS) && count($ORDERS) > 0)
                                                @foreach($ORDERS as $ORDER)
                                                    @php
                                                        $statusClass = match($ORDER->order_status) {
                                                            'delivered' => 'badge-delivered',
                                                            'pending' => 'badge-pending',
                                                            'in_process' => 'badge-in_process',
                                                            'canceled' => 'badge-canceled',
                                                            default => 'badge-pending',
                                                        };
                                                    @endphp
                                                    <tr>
                                                        <td><strong>#{{ $ORDER->id }}</strong></td>
                                                        <td>INV-{{ sprintf('%05d', $ORDER->id) }}</td>
                                                        <td>{{ date('d M, Y h:i A', strtotime($ORDER->created_at)) }}</td>
                                                        <td><span class="badge-status {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $ORDER->order_status ?? 'pending')) }}</span></td>
                                                        <td><strong>${{ number_format($ORDER->order_total, 2) }}</strong></td>
                                                        <td>
                                                            <a href="{{ route('invoice', [$ORDER->id]) }}" class="btn-view-invoice" target="_blank"><i class="fa fa-file-alt mr-1"></i> Invoice</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" class="py-4 text-muted">You have not placed any orders yet.</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
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