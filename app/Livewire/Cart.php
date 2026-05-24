<?php

namespace App\Livewire;

use App\Contract\CartServiceInterface;
use Livewire\Attributes\Title;
use Livewire\Component;

class Cart extends Component
{
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

    public function increaseQuantity(string $sku, CartServiceInterface $cart)
    {
        $item = $cart->getItemBySku($sku);
        if ($item) {
            $product = \App\Models\Product::where('sku', $sku)->first();
            if ($product && $item->quantity < $product->stock) {
                $item->quantity++;
                $cart->addOrUpdate($item);
                $this->dispatch('cart-Update');
            }
        }
    }

    public function decreaseQuantity(string $sku, CartServiceInterface $cart)
    {
        $item = $cart->getItemBySku($sku);
        if ($item) {
            if ($item->quantity > 1) {
                $item->quantity--;
                $cart->addOrUpdate($item);
            } else {
                $cart->remove($sku);
            }
            $this->dispatch('cart-Update');
        }
    }

    public function removeItem(string $sku, CartServiceInterface $cart)
    {
        $cart->remove($sku);
        $this->dispatch('cart-Update');
    }

    #[Title('Cart')]
    public function render(CartServiceInterface $cart)
    {
        $cartData = $cart->all();
        return view('livewire.cart', [
            'cart_items' => $cartData->items,
            'cart_total' => $cartData->total,
            'cart_total_formated' => $cartData->total_formatted,
            'cart_subtotal_formated' => $cartData->subtotal_formatted,
            'cart_discount_formated' => $cartData->discount_formatted,
            'coupon' => $cartData->coupon,
        ]);
    }
}

