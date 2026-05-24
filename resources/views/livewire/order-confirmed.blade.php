    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js" defer></script>
        <script type="text/javascript" defer>
            window.addEventListener("load", function() {
                if (typeof confetti === 'function') {
                    confetti({
                        particleCount: 120,
                        spread: 80,
                        origin: { y: 0.6 }
                    });
                }
            });
        </script>
    @endpush

    <div class="container mx-auto max-w-[85rem] w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="w-full p-2 mx-auto md:w-1/2">
            @if ($order)
                <div class="relative flex flex-col bg-white shadow-lg pointer-events-auto rounded-xl dark:bg-neutral-800 border border-gray-150 dark:border-neutral-700">
                    <div class="relative overflow-hidden text-center bg-gray-900 min-h-32 rounded-t-xl dark:bg-neutral-950">
                        <!-- SVG Background Element -->
                        <figure class="absolute inset-x-0 bottom-0 -mb-px">
                            <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                viewBox="0 0 1920 100.1">
                                <path fill="currentColor" class="fill-white dark:fill-neutral-800"
                                    d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"></path>
                            </svg>
                        </figure>
                    </div>

                    <div class="relative z-10 -mt-12">
                        <!-- Icon -->
                        <span class="mx-auto flex justify-center items-center size-15.5 rounded-full border border-gray-200 bg-white text-green-600 shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                            <svg class="shrink-0 size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="p-4 overflow-y-auto sm:p-7">
                        <div class="text-center">
                            <h3 id="hs-ai-modal-label" class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                                Thank You For Your Order!
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-neutral-500 mt-1">
                                Invoice: <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $order->invoice_number }}</span>
                            </p>
                        </div>

                        <!-- Grid -->
                        <div class="grid grid-cols-1 gap-5 mt-5 sm:mt-8 sm:grid-cols-3 border-b border-gray-100 dark:border-neutral-700 pb-5">
                            <div>
                                <span class="block text-xs text-gray-500 uppercase dark:text-neutral-500">Amount to pay:</span>
                                <span class="block text-sm font-bold text-blue-600 dark:text-blue-400">{{ Number::currency($order->total, 'IDR') }}</span>
                            </div>

                            <div>
                                <span class="block text-xs text-gray-500 uppercase dark:text-neutral-500">Date created:</span>
                                <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>

                            <div>
                                <span class="block text-xs text-gray-500 uppercase dark:text-neutral-500">Payment:</span>
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $order->payment_method }}</span>
                            </div>
                        </div>

                        @if (str_contains(strtolower($order->payment_method), 'bank transfer'))
                            <div class="mt-6">
                                <h4 class="text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Payment Transfer Instructions</h4>

                                <ul class="flex flex-col mt-2">
                                    <li class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                                        <div class="flex items-center justify-between w-full">
                                            <span>Bank</span>
                                            <span class="font-semibold">{{ str_contains(strtolower($order->payment_method), 'bca') ? 'Bank Central Asia (BCA)' : 'Bank Negara Indonesia (BNI)' }}</span>
                                        </div>
                                    </li>
                                    <li class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                                        <div class="flex items-center justify-between w-full">
                                            <span>Account Name</span>
                                            <span class="font-semibold">Rezza Kurniawan</span>
                                        </div>
                                    </li>
                                    <li class="inline-flex items-center px-4 py-3 -mt-px text-sm text-gray-800 border border-gray-200 gap-x-2 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                                        <div class="flex items-center justify-between w-full">
                                            <span>Bank Account Number</span>
                                            <span class="font-bold text-blue-600 dark:text-blue-400 select-all">
                                                {{ str_contains(strtolower($order->payment_method), 'bca') ? '7145-0982-11' : '0238-9911-22' }}
                                            </span>
                                        </div>
                                    </li>
                                    <li class="inline-flex items-center px-4 py-3 -mt-px text-sm font-semibold text-gray-800 border border-gray-200 gap-x-2 bg-gray-50 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
                                        <div class="flex items-center justify-between w-full">
                                            <span>Total Transfer</span>
                                            <span class="text-blue-600 dark:text-blue-400 font-bold">{{ Number::currency($order->total, 'IDR') }}</span>
                                        </div>
                                    </li>
                                </ul>
                                <p class="text-xs text-gray-500 mt-2">Silakan lakukan transfer sesuai dengan nominal total di atas. Pesanan Anda akan diproses setelah pembayaran terverifikasi.</p>
                            </div>
                        @elseif ($order->payment_method === 'QRIS')
                            <div class="mt-6 text-center bg-gray-50 dark:bg-neutral-900 p-5 rounded-lg border">
                                <h4 class="text-sm font-bold text-gray-800 dark:text-neutral-200 uppercase mb-2">QRIS Dynamic Code</h4>
                                <div class="inline-block p-2 bg-white rounded-lg mb-2 shadow-xs">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($order->invoice_number . '|' . $order->total) }}" alt="QRIS QR Code" class="size-48">
                                </div>
                                <p class="text-xs text-gray-500">Scan QRIS di atas menggunakan aplikasi mobile banking atau e-wallet pilihan Anda sebesar <strong>{{ Number::currency($order->total, 'IDR') }}</strong>.</p>
                            </div>
                        @endif

                        <div class="my-6">
                            <h4 class="text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400 mb-2">Product Summaries</h4>
                            <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1">
                                @foreach ($order->items as $item)
                                    <x-single-product-list :item="$item" />
                                @endforeach
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="space-y-2 mt-6">
                            <a href="{{ route('product-catalog') }}"
                                class="block w-full px-3 py-2.5 font-semibold text-center text-white bg-blue-600 border border-transparent rounded-lg text-sm hover:bg-blue-700 transition">
                                Belanja Lagi
                            </a>
                            <a href="/"
                                class="block w-full px-3 py-2 text-sm font-semibold text-center text-gray-700 bg-gray-100 hover:bg-gray-200 border border-transparent rounded-lg dark:bg-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-600 transition">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center p-10 bg-white rounded-xl shadow-md border dark:bg-neutral-800 dark:border-neutral-700">
                    <svg class="size-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Order Tidak Ditemukan</h2>
                    <p class="text-sm text-gray-500 mb-6">Kami tidak dapat menemukan informasi pesanan terbaru Anda. Kemungkinan pesanan sudah diproses atau session Anda telah kedaluwarsa.</p>
                    <a href="{{ route('product-catalog') }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-semibold text-sm hover:bg-blue-700">
                        Kembali ke Katalog
                    </a>
                </div>
            @endif
        </div>
    </div>

