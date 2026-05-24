<?php

namespace App\Livewire;

use App\Contract\CartServiceInterface;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;

class Checkout extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $city = 'Bandung';
    public string $postal_code = '';
    public int $shipping_method_id = 1;
    public string $payment_method = 'Bank Transfer - BCA';

    public array $shipping_methods = [
        1 => ['name' => 'JNT - YES (1-2 Day)', 'price' => 25000, 'courier' => 'JNT'],
        2 => ['name' => 'JNT - REG (2-3 Day)', 'price' => 15000, 'courier' => 'JNT'],
        3 => ['name' => 'JNT - OKE (3-5 Day)', 'price' => 10000, 'courier' => 'JNT'],
    ];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|min:8|max:20',
            'address' => 'required|string|min:10',
            'city' => 'required|string',
            'postal_code' => 'required|string|min:5|max:10',
            'shipping_method_id' => 'required|integer|in:1,2,3',
            'payment_method' => 'required|string',
        ];
    }

    protected $validationAttributes = [
        'name' => 'Customer Name',
        'email' => 'Email Address',
        'phone' => 'Phone Number',
        'address' => 'Street Address',
        'city' => 'City',
        'postal_code' => 'Postal Code',
        'shipping_method_id' => 'Shipping Method',
        'payment_method' => 'Payment Method',
    ];

    public function getShippingPriceProperty()
    {
        return $this->shipping_methods[$this->shipping_method_id]['price'] ?? 0;
    }

    public string $couponCode = '';
    public ?string $couponMessage = null;

    public function applyCoupon(CartServiceInterface $cart)
    {
        $this->validate([
            'couponCode' => 'required|string',
        ]);

        $cart->applyCoupon($this->couponCode);
        
        $cartData = $cart->all();
        if ($cartData->coupon) {
            $this->couponMessage = 'Coupon applied successfully!';
        } else {
            $this->couponMessage = 'Invalid or expired coupon!';
            $cart->removeCoupon();
        }
    }

    public function removeCoupon(CartServiceInterface $cart)
    {
        $cart->removeCoupon();
        $this->couponCode = '';
        $this->couponMessage = 'Coupon removed.';
    }

    public function placeOrder(CartServiceInterface $cart)
    {
        $this->validate();

        $cartData = $cart->all();
        if ($cartData->items->isEmpty()) {
            session()->flash('error', 'Keranjang belanja Anda kosong.');
            return redirect()->route('product-catalog');
        }

        $orderId = null;

        DB::transaction(function() use ($cartData, $cart, &$orderId) {
            $shippingPrice = $this->shipping_price;
            $subtotal = $cartData->total;
            $total = $subtotal + $shippingPrice;

            // Generate invoice number
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            // 1. Create the Order
            $order = Order::create([
                'invoice_number' => $invoiceNumber,
                'customer_name' => $this->name,
                'customer_email' => $this->email,
                'customer_phone' => $this->phone,
                'shipping_address' => $this->address . ', ' . $this->city . ', ' . $this->postal_code,
                'shipping_method' => $this->shipping_methods[$this->shipping_method_id]['name'],
                'shipping_cost' => $shippingPrice,
                'payment_method' => $this->payment_method,
                'subtotal' => $cartData->subtotal,
                'total' => $total,
                'status' => 'pending',
                'coupon_code' => $cartData->coupon?->code,
                'discount_amount' => $cartData->discount,
            ]);

            if ($cartData->coupon) {
                $cartData->coupon->increment('used_count');
            }

            $orderId = $order->id;

            // 2. Create Order Items & Deduct Product Stock
            foreach ($cartData->items as $item) {
                $order->items()->create([
                    'product_sku' => $item->sku,
                    'product_name' => $item->product?->name ?? 'Unknown Product',
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);

                // Decrement product stock
                $product = Product::where('sku', $item->sku)->first();
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            // 3. Clear Cart
            $cart->clear();
            $this->dispatch('cart-Update');
        });

        // Save order ID to session for the confirmed page
        session(['last_order_id' => $orderId]);

        return redirect()->route('order-confirmed');
    }

    #[Title('Checkout')]
    public function render(CartServiceInterface $cart)
    {
        $cartData = $cart->all();
        $subtotal = $cartData->subtotal;
        $shipping = $this->shipping_price;
        $discount = $cartData->discount;
        $total = max(0, $subtotal - $discount) + $shipping;

        return view('livewire.checkout', [
            'cart_items' => $cartData->items,
            'subtotal_formatted' => $cartData->subtotal_formatted,
            'shipping_formatted' => Number::currency($shipping, 'IDR'),
            'discount_formatted' => $cartData->discount_formatted,
            'total_formatted' => Number::currency($total, 'IDR'),
            'coupon' => $cartData->coupon,
        ]);
    }
}
