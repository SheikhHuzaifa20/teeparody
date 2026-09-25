@extends('layouts.main')
@section('content')

@if ($banner == null)
    <section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="banner-content animate">
                    <h1><span class="blue">Custom Parody Tees</span>
                        <br>Wear the Satire
                    </h1>
                    <p>Bold pop-culture mashups and clever parody designs printed on premium tees. The kind of shirt
                        that starts conversations before you say a word.</p>
                    <a href="products.php" class="btn web-btn">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-girl">
        <img src="{{ asset('asset/images/banner-girl.png') }}" class="img-fluid" alt="">
    </div>
</section>
@else
    <section class="banner about-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="banner-content animate">
                        <h1><span class="blue">{{ $banner->title }}</span>{{ $banner->text2 }}

                        </h1>
                        {!! $banner->description !!}
                        <a href="{{ route('product') }}" class="btn web-btn">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-girl">
            <img src="{{ asset($banner->image) }}" class="img-fluid" alt="">
        </div>
    </section>
    @endif

<section class="collection-slider">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="shirt_slides">
                    <div class="shirt-slider owl-carousel owl-theme">
                        @foreach($product as $p)
                        <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset($p->product_images->first()->image_path)}}" class="img-fluid" alt="">
                                <h5>{{strip_tags($p->name)}}</h5>
                            </div>
                        </div>
                        @endforeach
                        {{-- <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset('asset/images/inner_images/white2.png')}}" class="img-fluid" alt="">
                                <h5>No Retreat Baby No Surrender</h5>
                            </div>
                        </div>
                        <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset('asset/images/inner_images/black3.png')}}" class="img-fluid" alt="">
                                <h5> God's Children: The Four Kings</h5>
                            </div>
                        </div>
                        <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset('asset/images/inner_images/white4.png')}}" class="img-fluid" alt="">
                                <h5>To Infinity and Beyoncé</h5>
                            </div>
                        </div>
                        <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset('asset/images/inner_images/black5.png')}}" class="img-fluid" alt="">
                                <h5> To Infinity and Bay Ridge</h5>
                            </div>
                        </div>
                        <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset('asset/images/inner_images/white6.png')}}" class="img-fluid" alt="">
                                <h5> Power To My People</h5>
                            </div>
                        </div>
                        <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset('asset/images/inner_images/black7.png')}}" class="img-fluid" alt="">
                                <h5> Hook'em Horns</h5>
                            </div>
                        </div>
                        <div class="item">
                            <div class="collection-shirt">
                                <img src="{{asset('asset/images/inner_images/white8.png')}}" class="img-fluid" alt="">
                                <h5> You've Got A Friend In Jesus</h5>
                            </div>
                        </div> --}}
                    </div>
                    <h2>{{$page->name}}</h2>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="discover-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="our-discover">
                    {{-- <h2><span class="blue">Tees You Won't Find Anywhere Else</span></h2>
                    <p>Our signature collection of ready-to-buy pop-culture mashups, printed on premium blanks and
                        shipped straight to your door.</p> --}}
                        {!! $page->content !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="discover_products animate">
                    <a href="javascript:;">
                        <img src="{{asset($page->image)}}" class="img-fluid" alt="">
                        <h5>{{$section[0]->value}}</h5>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="discover_products animate">
                    <a href="javascript:;">
                        <img src="{{asset($section[1]->value)}}" class="img-fluid" alt="">
                        <h5>{{$section[2]->value}}</h5>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="discover_products animate">
                    <a href="javascript:;">
                        <img src="{{asset($section[3]->value)}}" class="img-fluid" alt="">
                        <h5>{{$section[4]->value}}</h5>
                    </a>
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
