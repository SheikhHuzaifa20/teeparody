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

    <section class="product-section">
        <div class="container-fluid">
            <div class="row align-items-end">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="seller-heading">
                        <h2 class="blue">{{ $page->name }}</h2>
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($product as $item)
                    @php
                        $firstImg = null;
                        if (isset($item->product_images) && count($item->product_images) > 0) {
                            $firstImg = is_object($item->product_images[0]) ? $item->product_images[0]->image_path : $item->product_images[0]['image_path'];
                        }
                        $primaryImg = $firstImg ? asset($firstImg) : '';

                        $attributesData = [];
                        if (isset($item->attributes) && count($item->attributes) > 0) {
                            foreach ($item->attributes as $attr) {
                                $attrName = !empty($attr->attribute_name) ? $attr->attribute_name : 'Option';
                                $valName = !empty($attr->attribute_value_name) ? $attr->attribute_value_name : $attr->value;
                                $imgUrl = !empty($attr->image) ? asset($attr->image) : '';
                                if (!isset($attributesData[$attrName])) {
                                    $attributesData[$attrName] = [];
                                }
                                $attributesData[$attrName][] = [
                                    'val' => $valName,
                                    'image' => $imgUrl
                                ];
                            }
                        }
                    @endphp
                    <div class="col-lg-4 col-md-4 col-6 mb-4">
                        <div class="product-main {{ $loop->iteration % 2 != 0 ? 'bg-blk' : '' }}">
                            <div class="product-picture">
                                <a href="{{ route('product_detail', $item->id) }}">
                                    @if ($primaryImg)
                                        <img src="{{ $primaryImg }}" class="img-fluid" alt="{{ strip_tags($item->name) }}">
                                    @else
                                        <img src="{{ asset('asset/images/inner_images/white1.png') }}" class="img-fluid" alt="{{ strip_tags($item->name) }}">
                                    @endif
                                </a>
                            </div>
                            <div class="cart-btn">
                                <button type="button" class="btn web-btn" onclick='openAddToCartModal({{ $item->id }}, {{ json_encode(strip_tags($item->name)) }}, {{ ($item->discount_price ?? 0) > 0 ? $item->discount_price : ($item->base_price ?? 0) }}, {{ json_encode($primaryImg) }}, {{ json_encode($attributesData) }})'>
                                    add to cart
                                </button>
                            </div>
                            <div class="product-description">
                                <a href="{{ route('product_detail', $item->id) }}">
                                    <h4 class="blue mb-1">{{ strip_tags($item->name) }}</h4>
                                    <h6 class="mt-1">
                                        @if(($item->discount_price ?? 0) > 0)
                                            <span class="blue fw-bold" style="font-size: 18px;">${{ number_format($item->discount_price, 2) }}</span>
                                            <span class="text-muted text-decoration-line-through ms-2" style="font-size: 14px;">${{ number_format($item->base_price, 2) }}</span>
                                        @else
                                            <span class="blue fw-bold" style="font-size: 18px;">${{ number_format($item->base_price ?? 0, 2) }}</span>
                                        @endif
                                    </h6>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4>No products available at the moment.</h4>
                    </div>
                @endforelse
            </div>
            <!--<div class="col-lg-3 col-md-3 col-6">-->
            <!--    <div class="product-main">-->
            <!--        <div class="product-picture">-->
            <!--            <img src="images/product-8.png" class="img-fluid" alt="">-->
            <!--        </div>-->
            <!--        <div class="cart-btn">-->
            <!--            <button class="btn web-btn">add to cart</button>-->
            <!--        </div>-->
            <!--        <div class="product-description">-->
            <!--            <h4 class="blue">teeparody black printed t shirt</h4>-->
            <!--            <h6>$ 450.00 $ 15,00 <span class="red">Save $ 435.00</span></h6>-->
            <!--            <h6><span><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i-->
            <!--                        class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i-->
            <!--                        class="fa-solid fa-star"></i></span> 5.0 / 5 (22 Reviews)</h6>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-lg-3 col-md-3 col-6">-->
            <!--    <div class="product-main">-->
            <!--        <div class="product-picture">-->
            <!--            <img src="images/product-3.png" class="img-fluid" alt="">-->
            <!--        </div>-->
            <!--        <div class="cart-btn">-->
            <!--            <button class="btn web-btn">add to cart</button>-->
            <!--        </div>-->
            <!--        <div class="product-description">-->
            <!--            <h4 class="blue">teeparody white printed t shirt</h4>-->
            <!--            <h6>$ 450.00 $ 15,00 <span class="red">Save $ 435.00</span></h6>-->
            <!--            <h6><span><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i-->
            <!--                        class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i-->
            <!--                        class="fa-solid fa-star"></i></span> 5.0 / 5 (22 Reviews)</h6>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-lg-3 col-md-3 col-6">-->
            <!--    <div class="product-main">-->
            <!--        <div class="product-picture">-->
            <!--            <img src="images/product-6.png" class="img-fluid" alt="">-->
            <!--        </div>-->
            <!--        <div class="cart-btn">-->
            <!--            <button class="btn web-btn">add to cart</button>-->
            <!--        </div>-->
            <!--        <div class="product-description">-->
            <!--            <h4 class="blue">teeparody black printed t shirt</h4>-->
            <!--            <h6>$ 450.00 $ 15,00 <span class="red">Save $ 435.00</span></h6>-->
            <!--            <h6><span><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i-->
            <!--                        class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i-->
            <!--                        class="fa-solid fa-star"></i></span> 5.0 / 5 (22 Reviews)</h6>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

        </div>
    </section>


    <section class="collection-slider">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="shirt_slides">
                        <div class="shirt-slider owl-carousel owl-theme">
                            @foreach ($product as $p)
                                <div class="item">
                                    <div class="collection-shirt">
                                        <img src="{{ asset($p->product_images->first()->image_path) }}" class="img-fluid"
                                            alt="">
                                        <h5>{{ strip_tags($p->name) }}</h5>
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
                        <h2>{{ $section[0]->value }}</h2>
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
                        <h2><span class="blue">{{ $section[1]->value }}</span></h2>
                        {!! $section[2]->value !!}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="discover_products animate">
                        <a href="javascript:;">
                            <img src="{{ asset('asset/images/shirt-1.png') }}" class="img-fluid" alt="">
                            <h5>Encourage Products</h5>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="discover_products animate">
                        <a href="javascript:;">
                            <img src="{{ asset('asset/images/shirt-2.png') }}" class="img-fluid" alt="">
                            <h5>Inspire Products</h5>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="discover_products animate">
                        <a href="javascript:;">
                            <img src="{{ asset('asset/images/shirt-3.png') }}" class="img-fluid" alt="">
                            <h5>Promote Products</h5>
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
