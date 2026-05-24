<div>
     <div class="container mx-auto max-w-[85rem] w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid gap-10 md:grid-cols-10">
            <div class="md:col-span-7">
                <h1 class="mb-5 text-2xl font-light">Shopping Bag</h1>
                <div class="grid gap-5">
                    @forelse ($cart_items as $item)
                        <x-single-product-cart :item="$item" />
                    @empty
                        <p class="py-10 text-center text-gray-500">Your cart is empty.</p>
                    @endforelse
                </div>
            </div>
            <div class="md:col-span-3">
                <h1 class="mb-5 text-2xl font-light">Order Summary</h1>
                <div class="grid gap-5">
                    <!-- List Group -->
                    <ul class="flex flex-col mt-3">
                        <li
                            class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                            <div class="flex items-center justify-between w-full">
                                <span>Sub Total</span>
                                <span>{{ $cart_subtotal_formated }}</span>
                            </div>
                        </li>
                        @if($coupon)
                        <li
                            class="inline-flex items-center px-4 py-3 -mt-px text-sm text-green-600 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-green-500">
                            <div class="flex items-center justify-between w-full">
                                <span>Discount ({{ $coupon->code }})</span>
                                <span>-{{ $cart_discount_formated }}</span>
                            </div>
                        </li>
                        @endif
                        <li
                            class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                            <div class="flex items-center justify-between w-full">
                                <span>Shipping</span>
                                <span>—</span>
                            </div>
                        </li>
                        <li
                            class="inline-flex items-center px-4 py-3 -mt-px text-sm font-semibold text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
                            <div class="flex items-center justify-between w-full">
                                <span>Total</span>
                                <span>{{ $cart_total_formated }}</span>
                            </div>
                        </li>
                    </ul>
                    
                    <!-- Coupon Input -->
                    <div class="mt-4">
                        @if(!$coupon)
                            <div class="flex items-center gap-2">
                                <input type="text" wire:model="couponCode" placeholder="Promo code" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                                <button type="button" wire:click="applyCoupon" class="px-3 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-lg hover:bg-gray-900 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none whitespace-nowrap">Apply</button>
                            </div>
                            @if($couponMessage)
                                <p class="mt-2 text-sm {{ str_contains($couponMessage, 'Invalid') ? 'text-red-500' : 'text-green-600' }}">{{ $couponMessage }}</p>
                            @endif
                        @else
                            <div class="flex items-center justify-between p-3 text-sm bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/30 dark:border-green-800">
                                <span class="text-green-800 dark:text-green-300 font-medium">Coupon <strong>{{ $coupon->code }}</strong> applied!</span>
                                <button type="button" wire:click="removeCoupon" class="text-sm text-red-600 hover:underline">Remove</button>
                            </div>
                        @endif
                    </div>
                    <!-- End Coupon Input -->

                    <a href="{{ route('checkout') }}" wire:navigate
                        class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg cursor-pointer gap-x-2 hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Checkout Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
