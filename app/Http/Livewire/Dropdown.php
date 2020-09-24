<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dropdown extends Component
{

    /**
     * Structure
     * - value -> what to return
     * - name -> what to search
     * @var array
     */
    public array $options;
    /**
     * Used to name events
     * @var string
     */
    public string $name;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.dropdown');
    }
}
