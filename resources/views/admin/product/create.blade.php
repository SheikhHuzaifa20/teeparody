@extends('layouts.app')
@push('before-css')
    <link rel="stylesheet" href="{{ asset('plugins/vendors/dropify/dist/css/dropify.min.css') }}">
    <style>
        .variation{
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
            background: #fff;
            border: 1.5px solid #e0e4ea;
            border-radius: 10px;
            padding: 14px 16px 10px;
            margin-bottom: 10px !important;
            position: relative;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .variation-row:hover {
            border-color: #7367f0;
            box-shadow: 0 4px 14px rgba(115,103,240,0.1);
        }
        .var-field-group {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            align-items: flex-end;
        }
        .var-field-group .vf-attr   { flex: 0 0 22%; }
        .var-field-group .vf-val    { flex: 0 0 22%; }
        .var-field-group .vf-price  { flex: 0 0 14%; }
        .var-field-group .vf-qty    { flex: 0 0 10%; }
        .var-field-group .vf-img    { flex: 0 0 20%; }
        .var-field-group .vf-del    { flex: 0 0 8%; display:flex; align-items:flex-end; }
        .var-field-group > div > label {
            font-size: 11px;
            font-weight: 700;
            color: #6e6b7b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }
        .var-field-group .form-control {
            font-size: 13px;
            height: 36px;
            padding: 4px 10px;
        }
        .var-img-wrap {
            position: relative;
            display: inline-block;
            margin-top: 4px;
        }
        .var-img-wrap img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #e0e4ea;
            display: block;
        }
        .var-file-label {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            background: #f3f2ff;
            border: 1.5px dashed #7367f0;
            border-radius: 6px;
            color: #7367f0;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }
        .var-file-label:hover { background: #e8e6ff; }
        .var-file-label input[type=file] { display: none; }
        .var-delete-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff0f0;
            border: 1.5px solid #ffcdd2;
            color: #dc3545;
            transition: all 0.2s;
            cursor: pointer;
        }
        .var-delete-btn:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }
        #variations-container { min-height: 4px; }
        #add-variation-btn {
            font-size: 13px;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 8px;
        }
    </style>
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Create New Product</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/product') }}">Product Management</a></li>
                        <li class="breadcrumb-item active">Create New Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <section id="basic-form-layouts">
            <form class="form" enctype="multipart/form-data" method="post" action="{{ route('admin.product.store') }}">
                @csrf
                <div class="row match-height">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">Product Info</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            {{-- <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Product Name</label>
                                                    <input class="form-control" required name="name" type="text"
                                                        id="name" value="{{ old('name') }}">
                                                </div>
                                            </div> --}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="summary-ckeditor1">Product Name</label>
                                                    <textarea name="name" id="summary-ckeditor1" cols="30" rows="10" class="form-control" required>{{ old('name') }}</textarea>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sku">SKU</label>
                                                    <input class="form-control" required name="sku" type="text"
                                                        id="sku" value="{{ old('sku') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="slug">Slug</label>
                                                    <input class="form-control" required name="slug" type="text"
                                                        id="slug" value="{{ old('slug') }}">
                                                </div>
                                            </div> --}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="summary-ckeditor">Description</label>
                                                    <textarea name="description" id="summary-ckeditor" cols="30" rows="10" class="form-control" required>{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">Product Image</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="summary-ckeditor">Image</label>
                                                    <div class="upload-photo">
                                                        <input class="form-control dropify" name="image" type="file"
                                                            id="image">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="summary-ckeditor">Gallery Image</label>
                                                    <div class="upload-photo">
                                                        <input class="form-control dropify" name="images[]" type="file"
                                                            id="images" multiple>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">Product Variations</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div id="variations-container">
                                            {{-- Rows will be added via JS --}}
                                        </div>
                                        <button type="button" id="add-variation-btn" class="btn btn-primary mt-1">
                                            <i class="ft-plus"></i> Add
                                        </button>
                                    </div>
                                    <div class="form-actions text-right pb-0 mt-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Add Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-colored-form-control">Information</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="card-text">
                                        @if ($errors->any())
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="alert alert-danger">
                                                        {{ $error }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if (Session::has('message'))
                                            <ul>
                                                <li class="alert alert-success">
                                                    {{ Session::get('message') }}
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">Pricing</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="base_price">Price</label>
                                                    <input class="form-control" required="required" name="base_price"
                                                        type="number" step="any" id="base_price"
                                                        value="{{ old('base_price') }}">
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="discount_price">Discount Price</label>
                                                    <input class="form-control" name="discount_price" type="number"
                                                        step="any" id="discount_price"
                                                        value="{{ old('discount_price') }}">
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-md-6 ml-1">
                                                <label>Charge tax on this product</label><br>
                                                <label class="switch">
                                                    <input type="checkbox" name="is_charge_tax" id="is_charge_tax"
                                                        checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="col-md-6 ml-1">
                                                <label>Stock</label><br>
                                                <label class="switch">
                                                    <input type="checkbox" name="stock" id="stock" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">Organize</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            {{-- <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Select Category</label>
                                                    <select id="category" class="form-control select2"
                                                        name="category_id"
                                                        data-selected="{{ old('category_id') }}">
                                                        <option value="">Select Category</option>
                                                    </select>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="col-md-12" id="subcat-container" style="display:none;">
                                                <div class="form-group">
                                                    <label>Select Sub Category</label>
                                                    <select id="subcategory" class="form-control select2"
                                                        name="sub_category_id"
                                                        data-selected="{{ old('sub_category_id') }}">
                                                        <option value="">Select Sub Category</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="tags-input">Tags</label>
                                                    <div class="tags-box border p-2 rounded" id="tags-box">
                                                        <input type="text" class="tags-input" id="tags-input"
                                                            placeholder="Type and press Enter">
                                                    </div>
                                                    <input type="hidden" name="tags" id="tags-hidden"
                                                        value="{{ old('tags') }}">
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            $('.dropify').dropify();
        });

        $(document).ready(function() {

            // ============================================================
            // VARIATION SYSTEM (Custom – no jQuery Repeater)
            // ============================================================
            var variationIndex = 0;
            var attributesData = @json($attributes);  // all attributes from blade
            var ajaxUrl = "{{ route('admin.product.get-attribute-values') }}";
            var csrfToken = "{{ csrf_token() }}";

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
                var imagePreview = '';
                if (opts.imageUrl) {
                    imagePreview = '<div class="var-img-preview mt-1">' +
                        '<img src="' + opts.imageUrl + '" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">' +
                        '</div>';
                }

                var row = $('<div class="variation-row row align-items-end mb-2" data-idx="' + idx + '">' +
                    '<div class="form-group col-md-3 variation">' +
                        '<label>Attribute</label>' +
                        '<select class="form-control var-attribute select2" name="product_attributes[' + idx + '][attribute_id]">' +
                            buildAttributeOptions(opts.attribute_id) +
                        '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-3 variation">' +
                        '<label>Value</label>' +
                        '<select class="form-control var-value select2" name="product_attributes[' + idx + '][value]"' +
                            ' data-preselect="' + (opts.value_id || '') + '">' +
                            '<option value="">Select Value</option>' +
                        '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-2 variation">' +
                        '<label>Price</label>' +
                        '<input type="number" step="any" min="0" class="form-control" name="product_attributes[' + idx + '][price]" value="' + (opts.price || '') + '">' +
                    '</div>' +
                    '<div class="form-group col-md-1 variation">' +
                        '<label>Qty</label>' +
                        '<input type="number" min="0" class="form-control" name="product_attributes[' + idx + '][qty]" value="' + (opts.qty !== undefined ? opts.qty : '') + '">' +
                    '</div>' +
                    '<div class="form-group col-md-2 variation">' +
                        '<label>Image <small class="text-muted">(optional)</small></label>' +
                        '<input type="file" class="form-control var-image-input" name="product_attributes[' + idx + '][image]" accept="image/*">' +
                        imagePreview +
                    '</div>' +
                    '<div class="form-group col-md-1 variation d-flex align-items-end">' +
                        '<button type="button" class="btn btn-danger btn-sm remove-variation-btn">Delete</button>' +
                    '</div>' +
                '</div>');

                $('#variations-container').append(row);

                // Init select2 on new row
                row.find('.select2').select2({ width: '100%' });

                // If editing: load values for pre-selected attribute
                if (opts.attribute_id) {
                    loadValues(row.find('.var-attribute'), opts.value_id);
                }

                // Image preview on file change
                row.find('.var-image-input').on('change', function() {
                    var previewDiv = row.find('.var-img-preview');
                    if (previewDiv.length === 0) {
                        previewDiv = $('<div class="var-img-preview mt-1"></div>');
                        $(this).after(previewDiv);
                    }
                    var file = this.files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            previewDiv.html('<img src="' + e.target.result + '" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">');
                        };
                        reader.readAsDataURL(file);
                    }
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
                    data: { _token: csrfToken, attribute_id: attributeId },
                    success: function(res) {
                        valueSelect.html('<option value="">Select Value</option>');
                        if (res.status) {
                            $.each(res.data, function(i, val) {
                                var sel = (preselect && preselect == val.id) ? 'selected' : '';
                                valueSelect.append('<option value="' + val.id + '" ' + sel + '>' + val.value + '</option>');
                            });
                        }
                        if (valueSelect.data('select2')) valueSelect.select2('destroy');
                        valueSelect.select2({ width: '100%' });
                    }
                });
            }

            // Add button click
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

        });

        let tags = [];
        const tagInput = document.getElementById('tags-input');
        const tagBox = document.getElementById('tags-box');
        const hiddenField = document.getElementById('tags-hidden');

        // Load old tags
        @if (old('tags'))
            let oldTags = @json(explode(',', old('tags')));
            oldTags.forEach(t => addTag(t));
        @endif

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
    </script>

    <script>
        $(function() {
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
        });
    </script>
@endpush
