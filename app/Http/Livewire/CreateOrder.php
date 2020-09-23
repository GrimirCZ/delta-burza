<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateOrder extends Component
{

    /**
     * Two states -> [ALL, SELECT]
     * ALL -> view all added exhibitions
     * NEW -> add new exhibition to the order
     * EDIT -> edit exhibition already added to the order
     * @var string
     */
    public string $state = "ALL";

    public array $selected_exhibitions;
    public ?object $selected_exhibition;

    public $listeners = ['transfer' => 'render'];

    public function mount()
    {
        $this->selected_exhibitions = [];
    }

    public function edit($id)
    {

    }

    public function remove(int $id)
    {
        $this->selected_exhibitions = collect($this->selected_exhibitions)->filter(fn($se) => $se->id != $id);
    }

    public function add()
    {
        $this->state = "NEW";
        $this->emit("transfer");
    }

    public function create()
    {
        $this->emit();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if($this->state == "ALL")
            return view('livewire.create-order', [
                'selected_exhibitions' => $this->selected_exhibitions
            ]);
        else if($this->state == "NEW")
            return view("order.create", [
                'exhibitions' => Exhibition::where("date", ">", DB::raw("CURRENT_DATE"))
                    ->whereNotIn("id", collect($this->selected_exhibitions)->map(fn($ex) => $ex->id))
                    ->get()
            ]);
        else
            return abort(500);
    }
}
