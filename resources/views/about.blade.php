@extends('layouts.main')
@section('content')

<section class="banner about-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="banner-content animate">
                    <h1><span class="blue">{{$banner->title}}</span>{{$banner->text2}}
                    </h1>
                    {!! $banner->description !!}
                    <a href="{{route('product')}}" class="btn web-btn">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-girl">
        <img src="{{asset('asset/images/banner-girl.png')}}" class="img-fluid" alt="">
    </div>
</section>


<section class="about-the-product">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12">
                <div class="about-img">
                    <img src="{{asset($page->image)}}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-12">
                <div class="abput-content">
                    <h2>{{$page->name}} <span class="blue d-block">{{$page->text2}}</span></h2>
                    {!! $page->content !!}
                    <a href="{{route('product')}}" class="btn web-btn">Learn More</a>
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
