<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $qty = (int) $request->input('qty', 1);
        $attributes = $request->input('attributes', []);
        $selectedImage = $request->input('image');

        $product = DB::table('products')->where('id', $productId)->first();

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found.']);
        }

        // Handle attributes input (array or JSON string)
        if (is_string($attributes)) {
            $decoded = json_decode($attributes, true);
            if (is_array($decoded)) {
                $attributes = $decoded;
            }
        }

        $attrList = [];
        $attrArray = [];
        if (is_array($attributes)) {
            foreach ($attributes as $key => $val) {
                if (!empty($val)) {
                    $attrList[] = $key . ': ' . $val;
                    $attrArray[$key] = $val;
                }
            }
        } elseif (is_string($attributes) && !empty($attributes)) {
            $attrList[] = $attributes;
        }

        // Fallback default attributes if none provided
        if (empty($attrList)) {
            $attrList = ['Color: Black', 'Size: Large (L)'];
            $attrArray = ['Color' => 'Black', 'Size' => 'Large (L)'];
        }

        $attrString = implode(', ', $attrList);

        // Always prioritize specific color attribute variation image if available in DB
        $colorVal = $attrArray['Color'] ?? $attrArray['color'] ?? null;
        if ($colorVal) {
            $attrMatch = DB::table('product_attributes')
                ->leftJoin('attributes_values', 'attributes_values.id', '=', 'product_attributes.value')
                ->where('product_attributes.product_id', $productId)
                ->where(function($q) use ($colorVal) {
                    $q->where('attributes_values.value', $colorVal)
                      ->orWhere('product_attributes.value', $colorVal);
                })
                ->whereNotNull('product_attributes.image')
                ->where('product_attributes.image', '!=', '')
                ->select('product_attributes.image')
                ->first();
            if ($attrMatch && !empty($attrMatch->image)) {
                $selectedImage = $attrMatch->image;
            }
        }

        if (empty($selectedImage) || $selectedImage === 'undefined') {
            $primaryImg = DB::table('product_images')->where('product_id', $productId)->first();
            $selectedImage = $primaryImg ? $primaryImg->image_path : 'asset/images/inner_images/white1.png';
        }

        $cart = Session::get('cart', []);

        // Unique key for cart item based on product ID, attributes and color image
        $cartKey = $productId . '_' . md5($attrString . '_' . $selectedImage);

        $price = ($product->discount_price > 0) ? $product->discount_price : $product->base_price;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'cart_key' => $cartKey,
                'name' => strip_tags($product->name),
                'price' => (float) $price,
                'baseprice' => (float) $price,
                'variation_price' => 0,
                'mat_language' => '',
                'variation' => [],
                'qty' => $qty,
                'image' => $selectedImage,
                'attributes' => $attrString,
                'attributes_array' => $attrArray,
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => count($cart),
            'cart_data' => $this->renderCartHtml($cart)
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $cartKey = $request->input('cart_key');
        $cart = Session::get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => count($cart),
            'cart_data' => $this->renderCartHtml($cart)
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $cartKey = $request->input('cart_key');
        $qty = (int) $request->input('qty', 1);
        $cart = Session::get('cart', []);

        if (isset($cart[$cartKey])) {
            if ($qty > 0) {
                $cart[$cartKey]['qty'] = $qty;
            } else {
                unset($cart[$cartKey]);
            }
            Session::put('cart', $cart);
        }

        return response()->json([
            'status' => true,
            'cart_count' => count($cart),
            'cart_data' => $this->renderCartHtml($cart)
        ]);
    }

    public function getDrawerContent()
    {
        $cart = Session::get('cart', []);
        return response()->json([
            'status' => true,
            'cart_count' => count($cart),
            'cart_data' => $this->renderCartHtml($cart)
        ]);
    }

    private function renderCartHtml($cart)
    {
        $subtotal = 0;
        $itemsHtml = '';
        $footerHtml = '';

        if (empty($cart)) {
            $itemsHtml = '
                <div class="text-center py-5">
                    <i class="fa-solid fa-basket-shopping text-muted mb-3" style="font-size: 3.5rem; opacity: 0.5;"></i>
                    <h5 class="text-secondary fw-bold">Your cart is empty</h5>
                    <p class="text-muted small">Explore our collection and add items to your cart.</p>
                </div>
            ';
            $footerHtml = '
                <div class="d-grid">
                    <a href="' . route('product') . '" class="btn btn-outline-primary fw-bold py-2">Continue Shopping</a>
                </div>
            ';
        } else {
            $itemsHtml .= '<div class="cart-items-list">';
            foreach ($cart as $key => $item) {
                $itemTotal = $item['price'] * $item['qty'];
                $subtotal += $itemTotal;
                
                $imgSrc = $item['image'];
                if (!str_starts_with($imgSrc, 'http://') && !str_starts_with($imgSrc, 'https://')) {
                    $imgSrc = asset($imgSrc);
                }

                $itemsHtml .= '
                    <div class="cart-item d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded border shadow-sm" style="transition: all 0.2s;">
                        <img src="' . $imgSrc . '" class="img-fluid rounded me-3 border" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="mb-1 text-dark fw-bold text-truncate" style="font-size: 0.9rem;" title="' . e($item['name']) . '">' . e($item['name']) . '</h6>
                            ' . ($item['attributes'] ? '<div class="text-muted mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-tag me-1 text-primary"></i>' . e($item['attributes']) . '</div>' : '') . '
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <span class="text-primary fw-bold" style="font-size: 0.95rem;">$' . number_format($item['price'], 2) . '</span>
                                <div class="input-group input-group-sm" style="width: 85px;">
                                    <button class="btn btn-outline-secondary btn-cart-minus px-2" data-key="' . e($key) . '" type="button">-</button>
                                    <input type="text" class="form-control text-center p-0 cart-qty-input bg-light fw-bold" data-key="' . e($key) . '" value="' . $item['qty'] . '" readonly>
                                    <button class="btn btn-outline-secondary btn-cart-plus px-2" data-key="' . e($key) . '" type="button">+</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-danger ms-2 btn-remove-cart p-1" data-key="' . e($key) . '" title="Remove item">
                            <i class="fa-solid fa-trash-can" style="font-size: 1rem;"></i>
                        </button>
                    </div>
                ';
            }
            $itemsHtml .= '</div>';

            $footerHtml = '
                <div class="bg-white p-3 rounded border shadow-sm mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-bold">Subtotal:</span>
                        <span class="h4 mb-0 fw-extrabold text-primary" style="letter-spacing: -0.5px;">$' . number_format($subtotal, 2) . '</span>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="' . route('checkout') . '" class="btn btn-primary fw-bold py-2 shadow-sm" style="background-color: #006bef; border-color: #006bef;">Proceed to Checkout <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            ';
        }

        return [
            'body' => $itemsHtml,
            'footer' => $footerHtml,
            'subtotal' => number_format($subtotal, 2),
        ];
    }
}
