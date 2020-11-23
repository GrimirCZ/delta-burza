<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowOrder extends Component
{
    public Order $order;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if(Auth::user()->id != $this->order->school->main_contact()->id){
            return abort(400);
        }

        return view('livewire.show-order', [
            'price' => number_format($this->order->price(), 0, ",", "."),
            'order_registrations' => $this->order
                ->ordered_registrations()
                ->join("registrations", "registrations.id", "=", "order_registration.registration_id")
                ->join("exhibitions", "exhibitions.id", "=", "registrations.exhibition_id")
                ->orderBy("exhibitions.date")
                ->select("order_registration.*")
                ->get(),
            'is_complete' => $this->order->ordered_registrations->every(fn($or) => $or != null)
        ]);
    }
}
