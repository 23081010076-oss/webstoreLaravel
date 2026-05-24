<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderConfirmed extends Component
{
    public ?Order $order = null;

    /**
     * Mount component and load last order from session.
     */
    public function mount()
    {
        $orderId = session('last_order_id');
        if ($orderId) {
            $this->order = Order::with('items.product.media')->find($orderId);
        }
    }

    #[Title('Order Confirmed')]
    public function render()
    {
        return view('livewire.order-confirmed', [
            'order' => $this->order
        ]);
    }
}
