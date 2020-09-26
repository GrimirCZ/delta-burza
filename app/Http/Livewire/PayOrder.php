<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class PayOrder extends Component
{
    public Order $order;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.pay-order');
    }
}
