@extends('layouts.app')
@push('before-css')
    <link rel="stylesheet" href="{{ asset('plugins/vendors/dropify/dist/css/dropify.min.css') }}">
    <style>
        .variation {
            position: relative;
            width: 100%;
            padding-right: 2px !important;
            padding-left: 2px !important;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            background: #0d6efd;
            color: white;
            padding: 3px 8px;
            border-radius: 15px;
            margin: 2px;
            font-size: 14px;
        }

        .tag .remove-tag {
            margin-left: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .tag-error {
            background: #dc3545 !important;
            color: white;
        }

        #tags-input {
            border: none;
            outline: none;
            padding: 5px;
            min-width: 120px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 28px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 28px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #0d6efd;
        }

        input:checked+.slider:before {
            transform: translateX(27px);
        }

        /* ===== VARIATION ROWS ===== */
        .variation-row {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 10px 4px;
            margin-bottom: 10px !important;
            position: relative;
            transition: box-shadow 0.2s;
        }

        .variation-row:hover {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .variation-row .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .variation-row .form-control {
            font-size: 13px;
        }

        .var-img-preview img,
        .var-existing-img img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #dee2e6;
            margin-top: 4px;
        }

        .var-existing-img {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
        }

        .remove-variation-btn {
            width: 100%;
        }

        #variations-container {
            min-height: 10px;
        }

        #add-variation-btn {
            font-size: 13px;
            padding: 7px 18px;
        }
    </style>
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Edit Product</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/product') }}">Product Management</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <section id="basic-form-layouts">
            <form class="form" enctype="multipart/form-data" method="post"
                action="{{ route('admin.product.update', $product->id) }}">
                @csrf
                @method('PUT')
                <div class="row match-height">
                    <div class="col-md-7">
                        <!-- Product Info -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Info</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            {{-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Product Name</label>
                                                <input class="form-control" required name="name" type="text"
                                                    id="name" value="{{ old('name', $product->name) }}">
                                            </div>
                                        </div> --}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="summary-ckeditor2">Product Name</label>
                                                    <textarea name="name" id="summary-ckeditor2" cols="30" rows="10" class="form-control" required>{{ old('name', $product->name) }}</textarea>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sku">SKU</label>
                                                <input class="form-control" required name="sku" type="text"
                                                    id="sku" value="{{ old('sku', $product->sku) }}">
                                            </div>
                                        </div> --}}
                                            {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="slug">Slug</label>
                                                <input class="form-control" required name="slug" type="text"
                                                    id="slug" value="{{ old('slug', $product->slug) }}">
                                            </div>
                                        </div> --}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="summary-ckeditor">Description</label>
                                                    <textarea name="description" id="summary-ckeditor" cols="30" rows="10" class="form-control" required>{{ old('description', $product->description) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Image</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Main Image</label>
                                        <input class="form-control dropify" name="image" type="file" id="image"
                                            data-default-file="{{ asset($primary_image) }}">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label>Gallery Images</label>
                                        <input class="form-control dropify" name="images[]" type="file" id="images"
                                            multiple>

                                        @if ($gallery_images)
                                            <div class="mt-2" id="gallery-images-container">
                                                @foreach ($gallery_images as $img)
                                                    <div class="gallery-image-wrapper" data-id="{{ $img->id }}"
                                                        style="display:inline-block; position:relative; margin:5px;">
                                                        <img src="{{ asset($img->image_path) }}" width="60"
                                                            class="rounded" />
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove-gallery-btn"
                                                            style="position:absolute; top:0; right:0; padding:2px 5px;">
                                                            &times;
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Product Variations -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Variations</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div id="variations-container">
                                        {{-- Rows rendered by JS from existing attributes --}}
                                    </div>
                                    <button type="button" id="add-variation-btn" class="btn btn-primary mt-2">
                                        <i class="ft-plus"></i> Add Variation
                                    </button>
                                    <div class="form-actions text-right pb-0 mt-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Update Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="col-md-5">
                        <!-- Messages & Alerts -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Information</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="card-text">
                                        @if ($errors->any())
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="alert alert-danger">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if (Session::has('message'))
                                            <ul>
                                                <li class="alert alert-success">{{ Session::get('message') }}</li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pricing</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="base_price">Price</label>
                                                <input class="form-control" required name="base_price" type="number"
                                                    step="any" id="base_price"
                                                    value="{{ old('base_price', $product->base_price) }}">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_price">Discount Price</label>
                                                <input class="form-control" name="discount_price" type="number"
                                                    step="any" id="discount_price"
                                                    value="{{ old('discount_price', $product->discount_price) }}">
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-md-6 ml-1">
                                            <div class="form-group">
                                                <label>Charge tax on this product</label><br>
                                                <label class="switch">
                                                    <input type="checkbox" name="is_charge_tax" id="is_charge_tax"
                                                        {{ $product->is_charge_tax ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-md-6 ml-1">
                                            <div class="form-group">
                                                <label>Stock</label><br>
                                                <label class="switch">
                                                    <input type="checkbox" name="stock" id="stock"
                                                        {{ $product->stock ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Organize -->
                        {{-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Organize</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select id="category" class="form-control select2" name="category_id"
                                            data-selected="{{ old('category_id', $product->category_id) }}">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="subcat-container"
                                        style="{{ $product->sub_category_id ? '' : 'display:none;' }}">
                                        <label>Select Sub Category</label>
                                        <select id="subcategory" class="form-control select2" name="sub_category_id"
                                            data-selected="{{ old('sub_category_id', $product->sub_category_id) }}">
                                            <option value="">Select Sub Category</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Tags</label>
                                        <div class="tags-box border p-2 rounded" id="tags-box">
                                            <input type="text" class="tags-input" id="tags-input"
                                                placeholder="Type and press Enter" value="">
                                        </div>
                                        <input type="hidden" name="tags" id="tags-hidden"
                                            value="{{ old('tags', $product->tags ?? '') }}">
                                    </div>

                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@push('js')
    <script src="{{ asset('plugins/vendors/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        $(function() {
            // Initialize Dropify
            $('.dropify').dropify();
        });

        $(document).ready(function() {

            // ============================================================
            // VARIATION SYSTEM (Custom – no jQuery Repeater)
            // ============================================================
            var variationIndex = 0;
            var attributesData = @json($attributes);
            @php
                $existingVariationsData = $product->attributes
                    ->map(function ($a) {
                        return [
                            'attribute_id' => $a->attribute_id,
                            'value_id' => $a->value,
                            'price' => $a->price,
                            'qty' => $a->qty,
                            'image' => $a->image,
                        ];
                    })
                    ->values()
                    ->toArray();
            @endphp
            var existingVariations = @json($existingVariationsData);
            var ajaxUrl = "{{ route('admin.product.get-attribute-values') }}";
            var csrfToken = "{{ csrf_token() }}";
            var assetBase = "{{ asset('') }}";

            function buildAttributeOptions(selectedId) {
                var html = '<option value="">Select Attribute</option>';
                $.each(attributesData, function(i, attr) {
                    var sel = (selectedId && selectedId == attr.id) ? 'selected' : '';
                    html += '<option value="' + attr.id + '" ' + sel + '>' + attr.name + '</option>';
                });
                return html;
            }

            function addVariationRow(opts) {
                opts = opts || {};
                var idx = variationIndex++;
                var existingImgHtml = '';
                if (opts.image) {
                    existingImgHtml =
                        '<div class="var-existing-img mt-1">' +
                        '<img src="' + assetBase + opts.image +
                        '" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">' +
                        '<button type="button" class="btn btn-danger btn-xs ml-1 remove-var-image-btn" data-idx="' +
                        idx + '">Remove</button>' +
                        '</div>' +
                        '<input type="hidden" name="product_attributes[' + idx +
                        '][existing_image]" class="existing-image-field" value="' + opts.image + '">';
                }

                var row = $('<div class="variation-row row align-items-end mb-2" data-idx="' + idx + '">' +
                    '<div class="form-group col-md-2 variation">' +
                    '<label>Attribute</label>' +
                    '<select class="form-control var-attribute select2" name="product_attributes[' + idx +
                    '][attribute_id]">' +
                    buildAttributeOptions(opts.attribute_id) +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-2 variation">' +
                    '<label>Value</label>' +
                    '<select class="form-control var-value select2" name="product_attributes[' + idx +
                    '][value]">' +
                    '<option value="">Select Value</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-2 variation">' +
                    '<label>Price</label>' +
                    '<input type="number" step="any" min="0" class="form-control" name="product_attributes[' +
                    idx + '][price]" value="' + (opts.price || '') + '">' +
                    '</div>' +
                    '<div class="form-group col-md-1 variation">' +
                    '<label>Qty</label>' +
                    '<input type="number" min="0" class="form-control" name="product_attributes[' + idx +
                    '][qty]" value="' + (opts.qty !== undefined && opts.qty !== null ? opts.qty : '') + '">' +
                    '</div>' +
                    '<div class="form-group col-md-3 variation img">' +
                    '<label>Image <small class="text-muted">(optional)</small></label>' +
                    '<input type="file" class="form-control var-image-input" name="product_attributes[' + idx +
                    '][image]" accept="image/*">' +
                    '<div class="var-img-preview"></div>' +
                    existingImgHtml +
                    '</div>' +
                    '<div class="form-group col-md-1 d-flex align-items-end">' +
                    '<button type="button" class="btn btn-danger btn-sm remove-variation-btn">Delete</button>' +
                    '</div>' +
                    '</div>');

                $('#variations-container').append(row);
                row.find('.select2').select2({
                    width: '100%'
                });

                // Load values from AJAX and preselect if editing
                if (opts.attribute_id) {
                    loadValues(row.find('.var-attribute'), opts.value_id);
                }

                // Image preview
                row.find('.var-image-input').on('change', function() {
                    var file = this.files[0];
                    var previewDiv = row.find('.var-img-preview');
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            previewDiv.html('<img src="' + e.target.result +
                                '" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">'
                            );
                        };
                        reader.readAsDataURL(file);
                        // Clear existing image when new uploaded
                        row.find('.var-existing-img').hide();
                        row.find('.existing-image-field').val('');
                    }
                });

                // Remove existing image
                row.find('.remove-var-image-btn').on('click', function() {
                    row.find('.var-existing-img').remove();
                    row.find('.existing-image-field').val('');
                });

                return row;
            }

            function loadValues(attributeSelect, preselect) {
                var attributeId = $(attributeSelect).val();
                if (!attributeId) return;
                var row = $(attributeSelect).closest('.variation-row');
                var valueSelect = row.find('.var-value');
                valueSelect.html('<option value="">Loading...</option>');

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        attribute_id: attributeId
                    },
                    success: function(res) {
                        valueSelect.html('<option value="">Select Value</option>');
                        if (res.status) {
                            $.each(res.data, function(i, val) {
                                var sel = (preselect !== undefined && preselect !== null &&
                                    preselect == val.id) ? 'selected' : '';
                                valueSelect.append('<option value="' + val.id + '" ' + sel +
                                    '>' + val.value + '</option>');
                            });
                        }
                        if (valueSelect.data('select2')) valueSelect.select2('destroy');
                        valueSelect.select2({
                            width: '100%'
                        });
                    }
                });
            }

            // Load existing variations on page load
            $.each(existingVariations, function(i, v) {
                addVariationRow(v);
            });

            // Add new variation
            $('#add-variation-btn').on('click', function() {
                addVariationRow();
            });

            // Attribute change
            $(document).on('change', '.var-attribute', function() {
                loadValues(this, null);
            });

            // Delete row
            $(document).on('click', '.remove-variation-btn', function() {
                if (confirm('Delete this variation?')) {
                    $(this).closest('.variation-row').remove();
                }
            });

            let categorySelected = $('#category').data('selected');
            let subcategorySelected = $('#subcategory').data('selected');

            // 🔹 CATEGORY SELECT2 (Infinite Scroll)
            $('#category').select2({
                placeholder: 'Select Category',
                width: '100%',
                ajax: {
                    url: "{{ route('admin.product.categories.select2') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        search: params.term || '',
                        page: params.page || 1
                    }),
                    processResults: (data, params) => {
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    }
                }
            });

            // 🔹 SUBCATEGORY SELECT2 (Depends on Category)
            function initSubcategory(categoryId) {
                $('#subcategory').select2({
                    placeholder: 'Select Sub Category',
                    width: '100%',
                    ajax: {
                        url: "{{ route('admin.product.subcategories.select2') }}",
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            category_id: categoryId,
                            search: params.term || '',
                            page: params.page || 1
                        }),
                        processResults: (data, params) => {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        }
                    }
                });
            }

            // 🔹 On Category Change
            $('#category').on('change', function() {
                let categoryId = $(this).val();
                $('#subcategory').val(null).trigger('change');

                if (categoryId) {
                    $('#subcat-container').show();
                    initSubcategory(categoryId);
                } else {
                    $('#subcat-container').hide();
                }
            });

            // 🔹 PRESELECT CATEGORY (Edit / old)
            if (categorySelected) {
                $.get("{{ route('admin.product.categories.select2') }}", {
                    id: categorySelected
                }, function(data) {
                    let option = new Option(data.text, data.id, true, true);
                    $('#category').append(option).trigger('change');
                });
            }

            // 🔹 PRESELECT SUBCATEGORY
            if (subcategorySelected && categorySelected) {
                $('#subcat-container').show();
                initSubcategory(categorySelected);

                $.get("{{ route('admin.product.subcategories.select2') }}", {
                    id: subcategorySelected
                }, function(data) {
                    let option = new Option(data.text, data.id, true, true);
                    $('#subcategory').append(option).trigger('change');
                });
            }

            // Tags input handling
            let tags = [];
            const tagInput = document.getElementById('tags-input');
            const tagBox = document.getElementById('tags-box');
            const hiddenField = document.getElementById('tags-hidden');

            // Load old tags from old() or existing product tags
            let existingTags = hiddenField.value ? hiddenField.value.split(',') : [];
            existingTags.forEach(t => addTag(t));

            // Add new tag on Enter
            tagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    let value = tagInput.value.trim();
                    if (value === "") return;

                    if (tags.includes(value.toLowerCase())) {
                        showDuplicateError(value);
                        tagInput.value = "";
                        return;
                    }

                    addTag(value);
                    tagInput.value = "";
                }
            });

            function addTag(text) {
                text = text.trim();
                if (!text) return;

                tags.push(text.toLowerCase());

                const tag = document.createElement('span');
                tag.classList.add('tag');
                tag.innerHTML = `${text}<span class="remove-tag">&times;</span>`;

                tag.querySelector('.remove-tag').addEventListener('click', function() {
                    tag.remove();
                    tags = tags.filter(t => t !== text.toLowerCase());
                    hiddenField.value = tags.join(',');
                });

                tagBox.insertBefore(tag, tagInput);
                hiddenField.value = tags.join(',');
            }

            function showDuplicateError(text) {
                const errorTag = document.createElement('span');
                errorTag.classList.add('tag', 'tag-error');
                errorTag.innerHTML = text;
                tagBox.insertBefore(errorTag, tagInput);
                setTimeout(() => errorTag.remove(), 1200);
            }


            $(document).on('click', '.remove-gallery-btn', function() {
                if (!confirm('Are you sure you want to delete this image?')) return;

                let wrapper = $(this).closest('.gallery-image-wrapper');
                let imageId = wrapper.data('id');

                $.ajax({
                    url: "{{ route('admin.product.gallery.destroy') }}", // create this route
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: imageId
                    },
                    success: function(res) {
                        if (res.success) {
                            wrapper.remove();
                            $.toast({
                                heading: 'Success',
                                text: 'Image deleted successfully.',
                                position: 'top-right',
                                icon: 'success',
                                loaderBg: '#5ba035',
                                hideAfter: 3000
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: 'Unable to delete image.',
                                position: 'top-right',
                                icon: 'error',
                                loaderBg: '#ff6849',
                                hideAfter: 3000
                            });
                        }
                    },
                    error: function() {
                        $.toast({
                            heading: 'Error',
                            text: 'Something went wrong.',
                            position: 'top-right',
                            icon: 'error',
                            loaderBg: '#ff6849',
                            hideAfter: 3000
                        });
                    }
                });
            });
        });
    </script>
@endpush
