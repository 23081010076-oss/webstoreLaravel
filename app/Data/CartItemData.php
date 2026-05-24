<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Product;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class CartItemData extends Data
{
    #[Computed]
    public ?ProductData $product = null;

    public function __construct(
        public string $sku,
        public int $quantity,
        public float $price,
        public int $weight
    ) {
        $productModel = Product::with(['media', 'tags'])->where('sku', $this->sku)->first();
        if ($productModel) {
            $this->product = ProductData::fromModel($productModel);
        }
    }
}
