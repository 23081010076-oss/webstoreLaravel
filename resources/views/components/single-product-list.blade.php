@props(['item'])
@php
    // Detect attributes from DTO (CartItemData) or Model (OrderItem)
    $name = $item->product_name ?? ($item->product?->name ?? 'Product Name');
    $sku = $item->product_sku ?? ($item->sku ?? '');
    $price = $item->price ?? 0;
    $quantity = $item->quantity ?? 1;

    // Get cover image from Spatie MediaLibrary without redundant database queries
    $coverUrl = null;
    if (isset($item->product) && is_object($item->product)) {
        if ($item->product instanceof \App\Data\ProductData) {
            $coverUrl = $item->product->cover_url;
        } elseif ($item->product instanceof \App\Models\Product) {
            $coverUrl = $item->product->getFirstMediaUrl('cover', 'cover');
        }
    }

    if (!$coverUrl) {
        $productModel = \App\Models\Product::with(['media'])->where('sku', $sku)->first();
        $coverUrl = $productModel?->getFirstMediaUrl('cover', 'cover') ?: 'https://images.unsplash.com/photo-1546087513-2a2bc7fb6fa9?q=80&w=2487&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
    }
@endphp
<div class="flex items-center gap-4 border-b border-gray-100 dark:border-neutral-800 pb-3 mb-3 last:border-b-0 last:pb-0 last:mb-0">
    <div class="relative overflow-hidden rounded-lg h-16 w-16 bg-gray-50 border border-gray-100 shrink-0">
        <img class="object-cover size-full"
            src="{{ $coverUrl }}"
            alt="{{ $name }}">
    </div>
    <div class="flex-1 min-w-0">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white truncate">
            {{ $name }}
        </h3>
        <h4 class="text-xs text-gray-400 font-mono truncate">sku: {{ $sku }}</h4>
        <div class="flex justify-between items-center mt-1">
            <span class="text-xs text-gray-500">{{ Number::currency($price, 'IDR') }} x {{ $quantity }}</span>
            <span class="text-sm font-bold text-gray-800 dark:text-neutral-200">{{ Number::currency($price * $quantity, 'IDR') }}</span>
        </div>
    </div>
</div>
