<?php
declare(strict_types=1);

namespace App\Data;

use App\Models\Coupon;
use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class CartData extends Data
{
    #[Computed]
    public float $subtotal;

    #[Computed]
    public float $discount;

    #[Computed]
    public float $total;

    public int $total_Weight;

    public int $total_quantity;

    public string $total_formatted;
    public string $subtotal_formatted;
    public string $discount_formatted;

    public ?Coupon $coupon = null;

    public function __construct(
        #[DataCollectionOf(CartItemData::class)]
        public DataCollection $items,
        public ?string $couponCode = null
    ) {
        $itemsCollection = $items->toCollection();
        $this->subtotal = $itemsCollection->sum(fn (CartItemData $item) => $item->price * $item->quantity);
        $this->total_Weight = $itemsCollection->sum(fn (CartItemData $item) => $item->weight ?? 0);
        $this->total_quantity = $itemsCollection->sum(fn (CartItemData $item) => $item->quantity);
        
        $this->discount = 0;
        
        if ($this->couponCode) {
            $this->coupon = Coupon::where('code', $this->couponCode)
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                })
                ->where(function($query) {
                    $query->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })
                ->where(function($query) {
                    $query->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
                })
                ->where(function($query) {
                    $query->whereNull('min_purchase')->orWhere('min_purchase', '<=', $this->subtotal);
                })
                ->first();

            if ($this->coupon) {
                if ($this->coupon->type === 'fixed') {
                    $this->discount = min($this->subtotal, (float) $this->coupon->value);
                } elseif ($this->coupon->type === 'percentage') {
                    $this->discount = ($this->subtotal * (float) $this->coupon->value) / 100;
                }
            }
        }

        $this->total = max(0, $this->subtotal - $this->discount);
        
        $this->subtotal_formatted = Number::currency($this->subtotal, 'IDR');
        $this->discount_formatted = Number::currency($this->discount, 'IDR');
        $this->total_formatted = Number::currency($this->total, 'IDR');
    }
}
