@extends('layouts.main')
@section('content')
    <section class="banner about-banner product-inner-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="banner-content animate">
                        <h1><span class="blue">Teeparody - {{ strip_tags($product->name) }}</span></h1>

                    </div>
                </div>
            </div>
        </div>
        <div class="banner-girl">
            <img src="{{ asset('images/banner-girl.png') }}" class="img-fluid" alt="">
        </div>
    </section>


    <section class="about-the-product">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="about-img product-inner-img">
                        @php
                            $firstImage = $product->images->first();
                            $primaryImgSrc = $firstImage ? asset($firstImage->image_path) : asset('images/noimage.png');
                        @endphp
                        <img id="productImage" src="{{ $primaryImgSrc }}" class="img-fluid"
                            alt="{{ strip_tags($product->name) }}">
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-12">
                    <div class="abput-content">
                        <h2>Teeparody -</h2>{!! $product->name !!}
                        {!! $product->description !!}

                        <div class="product-price-box my-3 p-3 rounded bg-light border-start border-4 border-primary shadow-sm">
                            @if(($product->discount_price ?? 0) > 0)
                                <span class="price-current text-primary fw-bold me-2" style="font-size: 1.8rem;">
                                    ${{ number_format($product->discount_price, 2) }}
                                </span>
                                <span class="price-old text-muted text-decoration-line-through me-2" style="font-size: 1.2rem;">
                                    ${{ number_format($product->base_price, 2) }}
                                </span>
                                <span class="badge bg-danger rounded-pill px-3 py-2" style="font-size: 0.85rem;">
                                    Save ${{ number_format($product->base_price - $product->discount_price, 2) }}
                                </span>
                            @else
                                <span class="price-current text-primary fw-bold" style="font-size: 1.8rem;">
                                    ${{ number_format($product->base_price ?? 0, 2) }}
                                </span>
                            @endif
                        </div>

                        <form id="productAttributeForm">
                            <div class="row">

                                @php
                                    $groupedAttributes = $product->attributes->groupBy('attribute_name');
                                @endphp

                                @if($groupedAttributes->count() > 0)
                                    @foreach ($groupedAttributes as $attributeName => $attributeValues)
                                        @php
                                            $displayName = $attributeName ?: 'Option';
                                        @endphp
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="attribute_{{ Str::slug($displayName) }}" class="fw-bold mb-1 text-dark">
                                                {{ $displayName }}:
                                            </label>
                                            <select id="attribute_{{ Str::slug($displayName) }}"
                                                class="form-control product-attribute py-2" name="attributes[{{ $displayName }}]">
                                                <option value="" data-image="">
                                                    Select {{ $displayName }}
                                                </option>
                                                @foreach ($attributeValues as $attribute)
                                                    @php
                                                        $valName = !empty($attribute->attribute_value_name) ? $attribute->attribute_value_name : $attribute->value;
                                                        $imgUrl = !empty($attribute->image) ? asset($attribute->image) : '';
                                                    @endphp
                                                    <option value="{{ $valName }}" data-image="{{ $imgUrl }}">
                                                        {{ $valName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attribute_color" class="fw-bold mb-1 text-dark">
                                            Color:
                                        </label>
                                        <select id="attribute_color" class="form-control product-attribute py-2" name="attributes[Color]">
                                            <option value="">Select Color</option>
                                            <option value="Black">Black</option>
                                            <option value="White">White</option>
                                            <option value="Navy Blue">Navy Blue</option>
                                            <option value="Heather Grey">Heather Grey</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attribute_size" class="fw-bold mb-1 text-dark">
                                            Size:
                                        </label>
                                        <select id="attribute_size" class="form-control product-attribute py-2" name="attributes[Size]">
                                            <option value="">Select Size</option>
                                            <option value="Small (S)">Small (S)</option>
                                            <option value="Medium (M)">Medium (M)</option>
                                            <option value="Large (L)">Large (L)</option>
                                            <option value="XL">XL</option>
                                            <option value="2XL">2XL</option>
                                        </select>
                                    </div>
                                @endif

                            </div>
                        </form>

                        <p class="mt-3"><b>Care:</b> Machine wash cold, inside out, and hang dry to keep the colors bright.</p>

                        <div class="d-flex align-items-center gap-3 my-4">
                            <div class="quantity-wrapper d-flex align-items-center border rounded bg-white p-1">
                                <label for="detailQty" class="me-2 fw-bold text-muted px-2 small">QTY:</label>
                                <input type="number" id="detailQty" class="form-control text-center border-0 fw-bold" value="1" min="1" style="width: 65px; height: 38px;">
                            </div>
                            <button type="button" class="btn web-btn py-2 px-4 shadow-sm" id="detailAddToCartBtn">
                                <i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart
                            </button>
                        </div>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var defaultImage = "{{ $primaryImgSrc }}";

            $('.product-attribute').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var newImage = selectedOption.attr('data-image');

                if (newImage && newImage.trim() !== '') {
                    $('#productImage').attr('src', newImage);
                } else {
                    var foundImage = false;
                    $('.product-attribute').each(function() {
                        var img = $(this).find('option:selected').attr('data-image');
                        if (img && img.trim() !== '') {
                            $('#productImage').attr('src', img);
                            foundImage = true;
                            return false;
                        }
                    });
                    if (!foundImage) {
                        $('#productImage').attr('src', defaultImage);
                    }
                }
            });

            $('#detailAddToCartBtn').on('click', function() {
                var productId = {{ $product->id }};
                var qty = parseInt($('#detailQty').val()) || 1;
                var attributes = {};

                $('.product-attribute').each(function() {
                    var name = $(this).attr('name').replace('attributes[', '').replace(']', '');
                    var val = $(this).val();
                    if (!val || val === '') {
                        var firstValid = $(this).find('option').filter(function() { return $(this).val() !== ''; }).first().val();
                        if (firstValid) {
                            val = firstValid;
                        }
                    }
                    if (val) {
                        attributes[name] = val;
                    }
                });

                var currentImg = $('#productImage').attr('src');

                addToCart(productId, qty, attributes, currentImg);
            });
        });
    </script>
@endsection
