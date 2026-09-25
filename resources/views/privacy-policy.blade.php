@php
    $page = DB::table('pages')->where('id', 10)->first();
@endphp
@extends('layouts.main')
@section('content')


<section class="banner about-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="banner-content animate">
                    <h1><span class="blue">{{ $page->name }}</span>

                    </h1>

                </div>
            </div>
        </div>
    </div>
</section>


<section class="policy-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="privacy-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</section>







@endsection
@section('css')
    <style>

    </style>
@endsection

@section('js')
    <script type="text/javascript"></script>
@endsection
