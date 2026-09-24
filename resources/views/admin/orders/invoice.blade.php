<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }} - Teeparody</title>

    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #212121; margin: 0; padding: 20px; }
        .header { display: table; width: 100%; margin-bottom: 20px; border-bottom: 2px solid #006bef; padding-bottom: 15px; }
        .header-cell { display: table-cell; vertical-align: top; }
        .brand { font-size: 24px; font-weight: bold; color: #006bef; }
        .badge { padding: 4px 10px; background: #e0f0ff; color: #006bef; border-radius: 4px; font-weight: bold; display: inline-block; }
        table.items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.items-table th { background: #006bef; color: #ffffff; padding: 10px; text-align: left; }
        table.items-table td { border-bottom: 1px solid #eeeeee; padding: 10px; }
        .text-right { text-align: right; }
        .totals-table { width: 40%; margin-left: auto; margin-top: 20px; border-collapse: collapse; }
        .totals-table td { padding: 6px 10px; }
        .totals-table tr.grand-total td { border-top: 2px solid #006bef; font-size: 14px; font-weight: bold; color: #006bef; }
    </style>
</head>

<body>

<div class="header">
    <div class="header-cell">
        <div class="brand">TEEPARODY</div>
        <p style="margin: 5px 0 0 0; color: #666;">Official Invoice</p>
        <p style="margin: 3px 0 0 0;"><strong>Invoice #:</strong> #{{ $order->invoice_number ?? $order->id }}</p>
        <p style="margin: 3px 0 0 0;"><strong>Date:</strong> {{ $order->created_at ? $order->created_at->format('d M, Y') : date('d M, Y') }}</p>
        <p style="margin: 3px 0 0 0;"><strong>Status:</strong> <span class="badge">{{ strtoupper($order->order_status ?? 'PENDING') }}</span></p>
    </div>

    <div class="header-cell text-right">
        <strong>Teeparody Inc.</strong><br>
        teeparody@gmail.com<br>
        www.teeparody.com
    </div>
</div>

{{-- Customer Information --}}
<div style="margin-bottom: 25px; background: #f9f9f9; padding: 12px; border-radius: 6px; border-left: 4px solid #006bef;">
    @php
        $custName = trim(($order->delivery_first_name ?? '') . ' ' . ($order->delivery_last_name ?? ''));
        if (empty($custName)) {
            $custName = $order->user->name ?? 'Customer';
        }
    @endphp
    <strong style="color: #006bef; font-size: 13px;">Billed To:</strong><br>
    <span style="font-size: 13px; font-weight: bold;">{{ $custName }}</span><br>
    @if(!empty($order->delivery_address_1)) {{ $order->delivery_address_1 }}<br> @endif
    @if(!empty($order->delivery_city)) {{ $order->delivery_city }} @endif @if(!empty($order->delivery_country)), {{ $order->delivery_country }} @endif<br>
    @if(!empty($order->order_email)) <strong>Email:</strong> {{ $order->order_email }}<br> @endif
    @if(!empty($order->delivery_phone_no)) <strong>Phone:</strong> {{ $order->delivery_phone_no }} @endif
</div>

{{-- Products Table --}}
<table class="items-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Description</th>
            <th class="text-right">Price</th>
            <th class="text-right">Qty</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @php $calcSubtotal = 0; @endphp
        @forelse($order->order_products as $item)
            @php
                $itemPrice = $item->order_products_price ?? $item->product?->base_price ?? 0;
                $itemQty = $item->order_products_qty ?? 1;
                $itemSubtotal = $item->order_products_subtotal ?? ($itemPrice * $itemQty);
                $calcSubtotal += $itemSubtotal;

                $itemImg = !empty($item->order_products_image) ? asset($item->order_products_image) : null;
                if (!$itemImg && $item->product) {
                    $imgRel = $item->product->images ?? $item->product->product_images;
                    if ($imgRel && $imgRel->count() > 0) {
                        $itemImg = asset($imgRel->first()->image_path);
                    }
                }

                $attrList = [];
                if (!empty($item->variants)) {
                    $decoded = json_decode($item->variants, true);
                    if (is_array($decoded)) {
                        foreach ($decoded as $k => $v) {
                            if (!empty($v)) {
                                $attrList[] = e($k) . ': ' . e($v);
                            }
                        }
                    } elseif (is_string($item->variants) && trim($item->variants) !== '' && $item->variants !== '[]' && $item->variants !== '{}') {
                        $attrList[] = e($item->variants);
                    }
                }
                if (empty($attrList) && !empty($item->mat_language)) {
                    $attrList[] = e($item->mat_language);
                }
                $attrStr = implode(' | ', $attrList);
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($itemImg)
                            <img src="{{ $itemImg }}" width="36" height="36" style="object-fit: contain; border: 1px solid #eee; border-radius: 4px; vertical-align: middle;">
                        @endif
                        <div>
                            <strong>{{ strip_tags($item->order_products_name ?? $item->product?->name ?? 'Product') }}</strong>
                            @if(!empty($attrStr))
                                <div style="font-size: 11px; color: #555; margin-top: 2px;">{{ $attrStr }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="text-right">${{ number_format($itemPrice, 2) }}</td>
                <td class="text-right">{{ $itemQty }}</td>
                <td class="text-right">${{ number_format($itemSubtotal, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center;">No product items found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Totals Table --}}
<table class="totals-table">
    <tr>
        <td class="text-right"><strong>Subtotal:</strong></td>
        <td class="text-right">${{ number_format($order->order_item_total ?? $calcSubtotal, 2) }}</td>
    </tr>
    @if(($order->order_shipping ?? 0) > 0)
    <tr>
        <td class="text-right"><strong>Shipping:</strong></td>
        <td class="text-right">${{ number_format($order->order_shipping, 2) }}</td>
    </tr>
    @endif
    <tr class="grand-total">
        <td class="text-right">Total:</td>
        <td class="text-right">${{ number_format($order->order_total ?? ($calcSubtotal + ($order->order_shipping ?? 0)), 2) }}</td>
    </tr>
</table>

<div style="margin-top: 40px; padding-top: 15px; border-top: 1px solid #eee; text-align: center; color: #777; font-size: 11px;">
    Thank you for shopping with <strong>Teeparody</strong>! If you have any questions, contact us at teeparody@gmail.com.
</div>

</body>
</html>
