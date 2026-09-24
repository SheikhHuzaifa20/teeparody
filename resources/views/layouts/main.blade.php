<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin">
    <meta name="author" content="Admin">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset(!empty($favicon->img_path) ? $favicon->img_path : '') }}">
    <title>{{ config('app.name') }}</title>
    <!-- ============================================================== -->
    <!-- All CSS LINKS IN BELOW FILE -->
    <!-- ============================================================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/inner.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/responsive.css') }}">
    @include('layouts.front.css')
    @yield('css')
    {{-- <style>
            .myaccount-tab-menu.nav a {
                display: block;
                padding: 20px;
                font-size: 16px;
                align-items: center;
                width: 100%;
                font-weight: bold;
                color: black;
                border-radius: 10px;
            }
            .myaccount-tab-menu.nav a i {
                padding-right: 10px;
            }

            .myaccount-tab-menu.nav {
                border: 1px solid;
                border-radius:10px;
            }

            .myaccount-tab-menu.nav .active, .myaccount-tab-menu.nav a:hover {
                background-color: #dd1017;
                color: white;
            }

            .account-details-form label.required {
                width: 100%;
                font-weight: 500;
                font-size: 18px;
            }
            .account-details-form input {
                border-width: 1px;
                border-color: white;
                border-style: solid;
                padding-left: 15px;
                color: black;
                width: 100%;
                border-radius: 3px;
                background-color: rgb(255, 255, 255);
                height: 52px;
                padding-left: 15px;
                margin-bottom: 30px;
                color: #000000;
                font-size: 15px;
            }
            .account-details-form legend {
                font-family: CottonCandies;
                font-size: 50px;
            }
            .editable {
                position: relative;
            }
            .editable-wrapper {
                position: absolute;
                right: 0px;
                top: -50px;
            }

            .editable-wrapper a {
                background-color: #17a2b8;
                border-radius: 50px;
                width: 35px;
                height: 35px;
                display: inline-block;
                text-align: center;
                line-height: 35px;
                color: white;
                margin-left: 10px;
                font-size: 16px;
            }
            .editable-wrapper a.edit{
                background-color: #007bff;
            }
        </style> --}}
</head>

<body class="responsive">


    @include('layouts/front.header')




    @yield('content')

    @if (Request::is('contact') ||
            Request::is('shipping-and-return-policy') ||
            Request::is('terms-and-conditions') ||
            Request::is('privacy-policy') ||
            Request::is('checkout') ||
            Request::is('account') ||
            Request::is('orders') ||
            Request::is('invoice/*') ||
            Request::is('account-detail') ||
            Request::is('signin') ||
            Request::is('signup'))
        @include('layouts/front.footer')
    @else
        @include('layouts/front.testimonials')
        @include('layouts/front.faq')
        @include('layouts/front.footer')
    @endif
    @include('layouts.front.cart-drawer')

    <!-- Select Product Options Modal -->
    <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addToCartModalLabel">Select Product Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <input type="hidden" id="modalProductId">
                    <input type="hidden" id="modalProductImage">
                    <div class="d-flex gap-3 align-items-center mb-3 p-2 bg-light rounded">
                        <img id="modalProductImgDisplay" src="" alt="" class="rounded border p-1" style="width: 75px; height: 75px; object-fit: contain; background: #fff;">
                        <div>
                            <h6 id="modalProductName" class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;"></h6>
                            <div id="modalProductPrice" class="fw-bold text-primary fs-5" style="color: #006bef !important;"></div>
                        </div>
                    </div>

                    <!-- Dynamic Attributes Container -->
                    <div id="modalAttributesContainer"></div>

                    <div class="mb-3">
                        <label for="modalQtyInput" class="form-label fw-bold text-dark small mb-1">Quantity</label>
                        <div class="d-flex align-items-center" style="width: 140px;">
                            <button type="button" class="btn btn-outline-secondary px-3" onclick="var el=document.getElementById('modalQtyInput'); el.value=Math.max(1, parseInt(el.value||1)-1);">-</button>
                            <input type="number" id="modalQtyInput" class="form-control text-center mx-1 fw-bold" value="1" min="1">
                            <button type="button" class="btn btn-outline-secondary px-3" onclick="var el=document.getElementById('modalQtyInput'); el.value=parseInt(el.value||1)+1;">+</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary py-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn web-btn py-2 px-4" id="confirmAddToCartBtn" style="background-color: #006bef; color: #fff; border-radius: 6px;">
                        <i class="fa-solid fa-cart-shopping me-1"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- All SCRIPTS ANS JS LINKS IN BELOW FILE -->
    <!-- ============================================================== -->
    @include('layouts/front.scripts')

    <script type="text/javascript">
        var modalDefaultImage = '';

        // Global Option Modal Handler
        function openAddToCartModal(id, name, price, image, attributesData) {
            $('#modalProductId').val(id);
            $('#modalProductImage').val(image);
            $('#modalProductName').text(name);
            $('#modalProductPrice').text('$' + parseFloat(price).toFixed(2));
            modalDefaultImage = image || '{{ asset("asset/images/inner_images/white1.png") }}';
            $('#modalProductImgDisplay').attr('src', modalDefaultImage);
            $('#modalQtyInput').val(1);

            var container = $('#modalAttributesContainer');
            container.empty();

            var initialImage = '';
            var hasAttributes = false;
            if (attributesData && typeof attributesData === 'object' && Object.keys(attributesData).length > 0) {
                hasAttributes = true;
                $.each(attributesData, function(attrName, values) {
                    var labelName = attrName || 'Option';
                    var html = '<div class="mb-3">';
                    html += '<label class="form-label fw-bold text-dark small mb-1">' + labelName + ' <span class="text-danger">*</span></label>';
                    html += '<select class="form-select py-2 modal-attribute-select" name="attributes[' + labelName + ']">';

                    if (Array.isArray(values)) {
                        $.each(values, function(i, valObj) {
                            var valName = valObj.val || '';
                            var imgUrl = valObj.image || '';
                            if (!initialImage && imgUrl) {
                                initialImage = imgUrl;
                            }
                            var selectedAttr = (i === 0) ? 'selected' : '';
                            html += '<option value="' + valName + '" data-image="' + imgUrl + '" ' + selectedAttr + '>' + valName + '</option>';
                        });
                    }
                    html += '</select></div>';
                    container.append(html);
                });
            }

            if (initialImage) {
                $('#modalProductImgDisplay').attr('src', initialImage);
            }

            if (!hasAttributes) {
                var fallbackHtml = `
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small mb-1">Color <span class="text-danger">*</span></label>
                        <select class="form-select py-2 modal-attribute-select" name="attributes[Color]">
                            <option value="Blue">Blue</option>
                            <option value="Black" selected>Black</option>
                            <option value="Red">Red</option>
                            <option value="Olive">Olive</option>
                            <option value="White">White</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small mb-1">Size <span class="text-danger">*</span></label>
                        <select class="form-select py-2 modal-attribute-select" name="attributes[Size]">
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large and XL" selected>Large and XL</option>
                        </select>
                    </div>
                `;
                container.append(fallbackHtml);
            }

            var modalEl = document.getElementById('addToCartModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            }
        }

        // Change modal image dynamically when attribute option changes
        $(document).on('change', '.modal-attribute-select', function() {
            var selectedOption = $(this).find('option:selected');
            var newImage = selectedOption.attr('data-image');

            if (newImage && newImage.trim() !== '') {
                $('#modalProductImgDisplay').attr('src', newImage);
            } else {
                var foundImage = false;
                $('.modal-attribute-select').each(function() {
                    var img = $(this).find('option:selected').attr('data-image');
                    if (img && img.trim() !== '') {
                        $('#modalProductImgDisplay').attr('src', img);
                        foundImage = true;
                        return false;
                    }
                });
                if (!foundImage) {
                    $('#modalProductImgDisplay').attr('src', modalDefaultImage);
                }
            }
        });

        // Global AJAX Cart Management
        function fetchCartDrawer() {
            $.ajax({
                url: "{{ route('cart.drawer_content') }}",
                type: "GET",
                success: function(response) {
                    if (response.status && response.cart_data) {
                        $('#cartDrawerBody').html(response.cart_data.body);
                        $('#cartDrawerFooter').html(response.cart_data.footer);
                        $('#cartCountBadge').text(response.cart_count);
                    }
                }
            });
        }

        function addToCart(productId, qty, attributes, image) {
            qty = qty || 1;
            attributes = attributes || {};
            image = image || '';

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    qty: qty,
                    attributes: attributes,
                    image: image
                },
                success: function(response) {
                    if (response.status) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message);
                        }
                        $('#cartCountBadge').text(response.cart_count);
                        if (response.cart_data) {
                            $('#cartDrawerBody').html(response.cart_data.body);
                            $('#cartDrawerFooter').html(response.cart_data.footer);
                        }

                        // Open Offcanvas Cart
                        var cartDrawerEl = document.getElementById('cartOffcanvas');
                        if (cartDrawerEl && typeof bootstrap !== 'undefined') {
                            var bsOffcanvas = bootstrap.Offcanvas.getInstance(cartDrawerEl) || new bootstrap
                                .Offcanvas(cartDrawerEl);
                            bsOffcanvas.show();
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message || 'Could not add product to cart.');
                        }
                    }
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Error adding item to cart.');
                    }
                }
            });
        }

        $(document).ready(function() {
            // Confirm Add To Cart from Modal
            $(document).on('click', '#confirmAddToCartBtn', function() {
                var productId = $('#modalProductId').val();
                var qty = parseInt($('#modalQtyInput').val()) || 1;
                var attributes = {};

                $('.modal-attribute-select').each(function() {
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

                var currentModalImg = $('#modalProductImgDisplay').attr('src');

                var modalEl = document.getElementById('addToCartModal');
                if (modalEl && typeof bootstrap !== 'undefined') {
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }

                addToCart(productId, qty, attributes, currentModalImg);
            });

            // Fetch initial cart state when cart offcanvas opens
            var cartDrawerEl = document.getElementById('cartOffcanvas');
            if (cartDrawerEl) {
                cartDrawerEl.addEventListener('show.bs.offcanvas', function() {
                    fetchCartDrawer();
                });
            }

            // Remove item from cart
            $(document).on('click', '.btn-remove-cart', function() {
                var cartKey = $(this).data('key');
                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cart_key: cartKey
                    },
                    success: function(response) {
                        if (response.status) {
                            if (typeof toastr !== 'undefined') {
                                toastr.info(response.message);
                            }
                            $('#cartCountBadge').text(response.cart_count);
                            if (response.cart_data) {
                                $('#cartDrawerBody').html(response.cart_data.body);
                                $('#cartDrawerFooter').html(response.cart_data.footer);
                            }
                        }
                    }
                });
            });

            // Quantity Plus
            $(document).on('click', '.btn-cart-plus', function() {
                var cartKey = $(this).data('key');
                var input = $(this).siblings('.cart-qty-input');
                var currentVal = parseInt(input.val()) || 1;
                var newVal = currentVal + 1;

                updateCartQty(cartKey, newVal);
            });

            // Quantity Minus
            $(document).on('click', '.btn-cart-minus', function() {
                var cartKey = $(this).data('key');
                var input = $(this).siblings('.cart-qty-input');
                var currentVal = parseInt(input.val()) || 1;
                var newVal = currentVal - 1;

                updateCartQty(cartKey, newVal);
            });

            function updateCartQty(cartKey, qty) {
                $.ajax({
                    url: "{{ route('cart.update_qty') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cart_key: cartKey,
                        qty: qty
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#cartCountBadge').text(response.cart_count);
                            if (response.cart_data) {
                                $('#cartDrawerBody').html(response.cart_data.body);
                                $('#cartDrawerFooter').html(response.cart_data.footer);
                            }
                        }
                    }
                });
            }
        });
    </script>
    @yield('js')

</body>

</html>
