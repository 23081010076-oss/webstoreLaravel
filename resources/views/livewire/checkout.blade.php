<div>
    <div class="container mx-auto max-w-[85rem] w-full px-4 sm:px-6 lg:px-8 py-10">
        @if (session()->has('error'))
            <div class="mb-5 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="placeOrder" class="grid gap-5 md:gap-20 md:grid-cols-2">
            <div class="p-5 md:p-10 bg-white dark:bg-neutral-900 rounded-xl shadow-xs border border-gray-100 dark:border-neutral-800">
                <!-- Section -->
                <div class="py-6 border-t border-gray-200 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                    <label class="inline-block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                        Billing Contact
                    </label>

                    <div class="grid grid-cols-2 gap-3 mt-2">
                        <div class="col-span-2">
                            <input type="text" wire:model.blur="name"
                                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @else focus:border-blue-500 focus:ring-blue-500 @enderror shadow-2xs sm:text-sm rounded-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Full Name">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input type="email" wire:model.blur="email"
                                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @else focus:border-blue-500 focus:ring-blue-500 @enderror shadow-2xs sm:text-sm rounded-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Email Address">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input type="text" wire:model.blur="phone"
                                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 @error('phone') border-red-500 focus:border-red-500 focus:ring-red-500 @else focus:border-blue-500 focus:ring-blue-500 @enderror shadow-2xs sm:text-sm rounded-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Phone Number">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section -->
                <div class="py-6 mt-5 border-t border-gray-200 first:pt-0 last:pb-0 first:border-transparent dark:border-neutral-700 dark:first:border-transparent">
                    <label class="inline-block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                        Billing Address
                    </label>

                    <div class="mt-2 space-y-3">
                        <div>
                            <input type="text" wire:model.blur="address"
                                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 @error('address') border-red-500 focus:border-red-500 focus:ring-red-500 @else focus:border-blue-500 focus:ring-blue-500 @enderror shadow-2xs sm:text-sm rounded-lg dark:bg-neutral-900 dark:border-neutral-700"
                                placeholder="Street Address (e.g. Jalan Raya No. 123)">
                            @error('address')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <input type="text" wire:model.blur="city"
                                    class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 @error('city') border-red-500 focus:border-red-500 focus:ring-red-500 @else focus:border-blue-500 focus:ring-blue-500 @enderror shadow-2xs sm:text-sm rounded-lg dark:bg-neutral-900 dark:border-neutral-700"
                                    placeholder="City (e.g. Bandung)">
                                @error('city')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <input type="text" wire:model.blur="postal_code"
                                    class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 @error('postal_code') border-red-500 focus:border-red-500 focus:ring-red-500 @else focus:border-blue-500 focus:ring-blue-500 @enderror shadow-2xs sm:text-sm rounded-lg dark:bg-neutral-900 dark:border-neutral-700"
                                    placeholder="Postal Code (e.g. 40190)">
                                @error('postal_code')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Method Section -->
                <div class="py-6 border-t border-gray-200 dark:border-neutral-700">
                    <label class="inline-block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                        Shipping Method
                    </label>
                    <div class="mt-2 space-y-3">
                        <div class="grid gap-2">
                            @foreach ($shipping_methods as $key => $method)
                                <label for="shipping_method_{{ $key }}"
                                    class="flex items-center justify-between w-full gap-2 p-3 text-sm bg-white border border-gray-200 rounded-lg cursor-pointer focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                    <div class="flex items-center justify-start gap-2">
                                        <input type="radio" wire:model.live="shipping_method_id" value="{{ $key }}"
                                            class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500"
                                            id="shipping_method_{{ $key }}">
                                        
                                        <span class="text-sm font-medium text-gray-800 dark:text-neutral-200 ms-3">
                                            {{ $method['name'] }}
                                        </span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                        {{ Number::currency($method['price'], 'IDR') }}
                                    </span>
                                </label>
                            @endforeach
                            @error('shipping_method_id')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="py-6 border-t border-gray-200 dark:border-neutral-700">
                    <label class="inline-block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                        Payment Method
                    </label>
                    <div class="mt-2 space-y-2">
                        @php
                            $payment_methods_list = [
                                'Bank Transfer - BCA',
                                'Bank Transfer - BNI',
                                'Virtual Account BCA',
                                'QRIS',
                                'Dana',
                            ];
                        @endphp
                        @foreach ($payment_methods_list as $key => $item)
                            <label for="payment_method_{{ $key }}"
                                class="flex items-center w-full p-3 text-sm bg-white border border-gray-200 rounded-lg cursor-pointer focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" wire:model.live="payment_method" value="{{ $item }}"
                                    class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 dark:bg-neutral-800"
                                    id="payment_method_{{ $key }}">
                                <span class="text-sm text-gray-800 font-medium ms-3 dark:text-neutral-200">{{ $item }}</span>
                            </label>
                        @endforeach
                        @error('payment_method')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Order Summary Column -->
            <div class="p-5 md:p-10 bg-white dark:bg-neutral-900 rounded-xl shadow-xs border border-gray-100 dark:border-neutral-800">
                <h2 class="mb-5 text-2xl font-semibold text-gray-800 dark:text-white border-b pb-3">Order Summary</h2>
                <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                    @forelse ($cart_items as $item)
                        <x-single-product-list :item="$item" />
                    @empty
                        <p class="py-5 text-center text-gray-500">Your shopping bag is empty.</p>
                    @endforelse
                </div>

                <div class="grid gap-5 mt-5">
                    <!-- List Group -->
                    <ul class="flex flex-col mt-3">
                        <li class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                            <div class="flex items-center justify-between w-full">
                                <span class="text-gray-500">Sub Total</span>
                                <span class="font-semibold">{{ $subtotal_formatted }}</span>
                            </div>
                        </li>
                        @if($coupon)
                        <li class="inline-flex items-center px-4 py-3 -mt-px text-sm text-green-600 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-green-500">
                            <div class="flex items-center justify-between w-full">
                                <span>Discount ({{ $coupon->code }})</span>
                                <span class="font-semibold">-{{ $discount_formatted }}</span>
                            </div>
                        </li>
                        @endif
                        <li class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                            <div class="flex items-center justify-between w-full">
                                <span class="flex flex-col">
                                    <span class="text-gray-500">Shipping ({{ $shipping_methods[$shipping_method_id]['name'] ?? 'Pilih Kurir' }})</span>
                                </span>
                                <span class="font-semibold">{{ $shipping_formatted }}</span>
                            </div>
                        </li>
                        <li class="inline-flex items-center px-4 py-3 -mt-px text-sm font-semibold text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200 bg-gray-50">
                            <div class="flex items-center justify-between w-full">
                                <span>Total Price</span>
                                <span class="text-lg text-blue-600 dark:text-blue-400 font-bold">{{ $total_formatted }}</span>
                            </div>
                        </li>
                    </ul>
                    <!-- End List Group -->

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

                    <button type="submit"
                        class="inline-flex items-center justify-center w-full px-4 py-3 text-base font-semibold text-white bg-blue-600 border border-transparent rounded-lg cursor-pointer gap-x-2 hover:bg-blue-700 focus:outline-hidden disabled:opacity-50">
                        <span>Place an Order</span>
                        
                        <!-- Spinner loading Livewire -->
                        <div wire:loading class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
