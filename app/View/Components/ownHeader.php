<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ownHeader extends Component
{
    public $top;
    public $bottom;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($top = "", $bottom = "")
    {
        $this->top = $top;
        $this->bottom = $bottom;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.own-header');
    }
}
