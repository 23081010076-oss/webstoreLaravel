<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class Homepage extends Component
{
    #[Title('Homepage')]
    public function render()
    {
        return view('livewire.homepage', [
            'featuredProducts' => \App\Data\ProductData::collect(Product::with(['media', 'tags'])->inRandomOrder()->take(3)->get()),
            'latestProducts' => \App\Data\ProductData::collect(Product::with(['media', 'tags'])->latest()->take(3)->get())
        ]);
    }
}
