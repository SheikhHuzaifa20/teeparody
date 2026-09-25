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
                        @if (request('search'))
                            <h2 class="blue">Search Results for "{{ request('search') }}"</h2>
                            <p>Showing products matching your search term. <a href="{{ route('product') }}"
                                    class="text-decoration-underline text-primary">Clear Search</a></p>
                        @else
                            <h2 class="blue">Find Your Next Favorite Tee</h2>
                            <p>Whether you're here for a laugh, a statement, or a gift that actually gets remembered, our
                                designs are sorted so you can find the right one fast. Explore the categories below and pick
                                the
                                shirt that fits your kind of funny.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">

                @forelse($product as $item)
                    @php
                        $attributesData = [];
                        if (isset($item->attributes) && count($item->attributes) > 0) {
                            foreach ($item->attributes as $attr) {
                                $attrName = !empty($attr->attribute_name) ? $attr->attribute_name : 'Option';
                                $valName = !empty($attr->attribute_value_name)
                                    ? $attr->attribute_value_name
                                    : $attr->value;
                                $imgUrl = !empty($attr->image) ? asset($attr->image) : '';
                                if (!isset($attributesData[$attrName])) {
                                    $attributesData[$attrName] = [];
                                }
                                $attributesData[$attrName][] = [
                                    'val' => $valName,
                                    'image' => $imgUrl,
                                ];
                            }
                        }
                        $primaryImg =
                            isset($item->product_images) && count($item->product_images) > 0
                                ? asset($item->product_images->first()->image_path)
                                : '';
                    @endphp
                    <div class="col-lg-4 col-md-4 col-6">

                        <div class="product-main {{ ($loop->iteration % 3 == 2) ? '' : 'bg-blk' }}">

                            <div class="product-picture">

                                <a href="{{ route('product_detail', $item->id) }}">

                                    @if (!empty($primaryImg))
                                        <img src="{{ $primaryImg }}" class="img-fluid"
                                            alt="{{ strip_tags($item->name) }}">
                                    @endif

                                </a>

                            </div>

                            <div class="cart-btn">
                                <button type="button" class="btn web-btn"
                                    onclick='openAddToCartModal({{ $item->id }}, {{ json_encode(strip_tags($item->name)) }}, {{ ($item->discount_price ?? 0) > 0 ? $item->discount_price : $item->base_price ?? 0 }}, {{ json_encode($primaryImg) }}, {{ json_encode($attributesData) }})'>
                                    add to cart
                                </button>
                            </div>

                            <div class="product-description">

                                <a href="{{ route('product_detail', $item->id) }}">

                                    <h4 class="blue mb-1">
                                        {{ strip_tags($item->name) }}
                                    </h4>

                                    <h6 class="mt-1">
                                        @if (($item->discount_price ?? 0) > 0)
                                            <span class="blue fw-bold"
                                                style="font-size: 18px;">${{ number_format($item->discount_price, 2) }}</span>
                                            <span class="text-muted text-decoration-line-through ms-2"
                                                style="font-size: 14px;">${{ number_format($item->base_price, 2) }}</span>
                                        @else
                                            <span class="blue fw-bold"
                                                style="font-size: 18px;">${{ number_format($item->base_price ?? 0, 2) }}</span>
                                        @endif
                                    </h6>

                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="text-center py-5">
                            <h4>No products found {{ request('search') ? 'matching "' . request('search') . '"' : '' }}.
                            </h4>
                            @if (request('search'))
                                <a href="{{ route('product') }}" class="btn web-btn mt-3">View All Products</a>
                            @endif
                        </div>

                    </div>
                @endforelse

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
