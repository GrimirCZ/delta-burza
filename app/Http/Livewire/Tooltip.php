<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tooltip extends Component
{
    public $title;
    public $content;
    public $show = false;

    protected $listeners = [
        'showTooltip' => 'open',
        'closeTooltip' => 'close',
    ];

    public function open()
    {
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.tooltip');
    }
}
