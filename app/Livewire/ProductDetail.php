<?php

namespace App\Livewire;

use App\Data\ProductData;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $productModel;

    public function mount(Product $product)
    {
        $product->load(['media', 'tags']);
        $this->productModel = $product;
    }

    #[Title('Product Detail')]
    public function render()
    {
        return view('livewire.product-detail', [
            'product' => ProductData::fromModel($this->productModel, true)
        ]);
    }
}
